<?php

namespace App\Http\Controllers;

use App\VulnSerpico;
use App\Criticidad;
use Illuminate\Http\Request;

class VulnSerpicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort = $request->input('sort'); 
        $order = $request->input('order');

        if($sort && $order) 
        {
            $vulnsserpico = VulnSerpico::with('criticidad')->sortable()->orderBy($sort, $order)->paginate(10);
            $links = $vulnsserpico->appends(['sort' => $sort, 'order' => $order])->links();
        }else{
            $vulnsserpico = VulnSerpico::with('criticidad')->orderBy('criticidad_id','desc')->sortable()->paginate(10);
            $links = $vulnsserpico->links();
        }

        return view('vulnsserpico.index',compact('vulnsserpico','links','sort','order'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $criticidades = Criticidad::all();
        return view('vulnsserpico.create', compact('criticidades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'titulo' => 'required|unique:vulnsserpico,titulo',
            'criticidad_id' => 'required',
            'descripcion' => 'required',
        ]);

        VulnSerpico::create($request->all());

        return redirect()->route('vulnsserpico.index')
                        ->with('success','Vulnerabilidad Serpico creada correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VulnSerpico  $vulnserpico
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('vulnsserpico.show', ['vulnserpico' => VulnSerpico::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VulnSerpico  $vulnserpico
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        return view('vulnsserpico.edit', ['vulnserpico' => VulnSerpico::findOrFail($id), 'criticidades' => Criticidad::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VulnSerpico  $vulnserpico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'titulo' => 'required|unique:vulnsserpico,titulo,'.$id,
            'criticidad_id' => 'required',
            'descripcion' => 'required',
        ]);
        $vulnserpico = VulnSerpico::findOrFail($id);
        $vulnserpico->update($request->all());


        return redirect()->route('vulnsserpico.index')
                        ->with('success','VulnSerpico actualizada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VulnSerpico  $vulnserpico
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vulnserpico = VulnSerpico::findOrFail($id);
        $vulnserpico->delete();

        return redirect()->route('vulnsserpico.index')
                        ->with('success','VulnSerpico '. $vulnserpico->titulo .' eliminada');
    }

    public function import()
    {
        return view('vulnsserpico.import');
    }

    public function importar(Request $request)
    {
        try {

            $cant = 0;
            $duplicadas = 0;

            $path = $request->file('fileToUpload')->store('upload');
            
            $json = \Storage::disk('local')->get($path);

            \Storage::disk('local')->delete('$path');

            $vulns_serpico = json_decode($json);

            foreach ($vulns_serpico as $vulnserpico) {
                //Solo criticidades Criticas, Altas y Medias
                if($vulnserpico->risk < 2){
                    continue;
                }

                //Busco por idSerpico
                $vuln = VulnSerpico::where('id_serpico',$vulnserpico->id)->first();
                $vulnserpico->overview = str_replace('</paragraph>',"\r\n",$vulnserpico->overview);
                $vulnserpico->overview = str_replace('<paragraph>', '',$vulnserpico->overview);
                $vulnserpico->remediation = str_replace('</paragraph>',"\r\n",$vulnserpico->remediation);
                $vulnserpico->remediation = str_replace('<paragraph>', '' ,$vulnserpico->remediation);
                $vulnserpico->references = str_replace('</paragraph>',"\r\n",$vulnserpico->references);
                $vulnserpico->references = str_replace('<paragraph>', '' ,$vulnserpico->references);
                
                //Si no existe se crea
                if (!$vuln) {
                    $cant++;
                    $new_vuln = new VulnSerpico;
                    $new_vuln->titulo = $vulnserpico->title;
                    $new_vuln->criticidad_id = $vulnserpico->risk;
                    $new_vuln->id_serpico = $vulnserpico->id;
                    $new_vuln->descripcion = $vulnserpico->overview;
                    $new_vuln->remediacion = $vulnserpico->remediation;
                    $new_vuln->referencias = $vulnserpico->references;
                    $new_vuln->save();
                }else{
                    // Si existe sumo duplicadas
                    $duplicadas++;
                }
                
            }
            $array_msg = [];
            if($cant >0)
            {
                $array_msg = ['success' => $cant.' vulnerabilidades importadas correctamente'];
            }
            if(($duplicadas)>0)
            {
                $array_msg = ['error' => '<p><strong>Duplicadas: </strong>'.$duplicadas.' vulnerabilidades NO importadas</p>'];
            }

            return redirect()->route('vulnsserpico.index')
                        ->with($array_msg);
        
        } catch (\Exception $ex) {
            return redirect()->route('vulnsserpico.index')
                        ->with('error','Error al importar las vulnerabilidades');
        }
    }
}
