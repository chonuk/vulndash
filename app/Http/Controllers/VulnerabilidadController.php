<?php

namespace App\Http\Controllers;

use App\Vulnerabilidad;
use App\Criticidad;
use Illuminate\Http\Request;

class VulnerabilidadController extends Controller
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
            $vulnerabilidades = Vulnerabilidad::with('criticidad')->sortable()->orderBy($sort, $order)->paginate(10);
            $links = $vulnerabilidades->appends(['sort' => $sort, 'order' => $order])->links();
        }else{
            $vulnerabilidades = Vulnerabilidad::with('criticidad')->orderBy('criticidad_id','desc')->sortable()->paginate(10);
            $links = $vulnerabilidades->links();
        }

        return view('vulnerabilidades.index',compact('vulnerabilidades','links','sort','order'))
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
        return view('vulnerabilidades.create', compact('criticidades'));
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
            'titulo' => 'required',
            'criticidad_id' => 'required',
            'descripcion' => 'required',
        ]);

        Vulnerabilidad::create($request->all());

        return redirect()->route('vulnerabilidades.index')
                        ->with('success','Vulnerabilidad creada correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vulnerabilidad  $vulnerabilidad
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('vulnerabilidades.show', ['vulnerabilidad' => Vulnerabilidad::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vulnerabilidad  $vulnerabilidad
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        #$criticidades = Criticidad::all();
        return view('vulnerabilidades.edit', ['vulnerabilidad' => Vulnerabilidad::findOrFail($id), 'criticidades' => Criticidad::all()]);
            #compact('vulnerabilidad','criticidades'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vulnerabilidad  $vulnerabilidad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'titulo' => 'required',
            'criticidad_id' => 'required',
            'descripcion' => 'required',
        ]);
        $vulnerabilidad = Vulnerabilidad::findOrFail($id);
        $vulnerabilidad->update($request->all());


        return redirect()->route('vulnerabilidades.index')
                        ->with('success','Vulnerabilidad actualizada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vulnerabilidad  $vulnerabilidad
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vulnerabilidad = Vulnerabilidad::findOrFail($id);
        $vulnerabilidad->delete();

        return redirect()->route('vulnerabilidades.index')
                        ->with('success','Vulnerabilidad eliminada');
    }

    public function importar()
    {
        return view('vulnerabilidades.importar');
    }

    public function import(Request $request)
    {
        try {

            $cant = 0;

            $path = $request->file('fileToUpload')->store('upload');
            
            $json = \Storage::disk('local')->get($path);

            \Storage::disk('local')->delete('$path');

            $vulns_serpico = json_decode($json);

            foreach ($vulns_serpico as $vulnerabilidad) {
                //Solo criticidades Criticas, Altas y Medias
                if($vulnerabilidad->risk < 2){
                    continue;
                }

                //Busco por idSerpico
                $vuln = Vulnerabilidad::where('id_serpico',$vulnerabilidad->id)->first();
                $vulnerabilidad->overview = str_replace('<paragraph>','',$vulnerabilidad->overview);
                $vulnerabilidad->overview = str_replace('</paragraph>', '',$vulnerabilidad->overview);
                $vulnerabilidad->remediation = str_replace('<paragraph>','',$vulnerabilidad->remediation);
                $vulnerabilidad->remediation = str_replace('</paragraph>', '' ,$vulnerabilidad->remediation);
                $vulnerabilidad->references = str_replace('<paragraph>','',$vulnerabilidad->references);
                $vulnerabilidad->references = str_replace('</paragraph>', '' ,$vulnerabilidad->references);
                
                //Si no existe Creo el objeto y lo persisto
                if (!$vuln) {
                    $cant++;
                    $new_vuln = new Vulnerabilidad;
                    $new_vuln->titulo = $vulnerabilidad->title;
                    $new_vuln->criticidad_id = $vulnerabilidad->risk;
                    $new_vuln->id_serpico = $vulnerabilidad->id;
                    $new_vuln->descripcion = $vulnerabilidad->overview;
                    $new_vuln->remediacion = $vulnerabilidad->remediation;
                    $new_vuln->referencias = $vulnerabilidad->references;
                    $new_vuln->save();
                }else{
                    if($vuln->criticidad_id != $vulnerabilidad->risk){
                        $vuln->criticidad_id = $vulnerabilidad->risk;
                    }
                    if($vuln->titulo != $vulnerabilidad->title){
                        $vuln->titulo = $vulnerabilidad->title;
                    }
                    if($vuln->descripcion != $vulnerabilidad->overview){
                        $vuln->descripcion = $vulnerabilidad->overview;
                    }
                    if($vuln->remediacion != $vulnerabilidad->remediation){
                        $vuln->remediacion = $vulnerabilidad->remediation;
                    }
                    if($vuln->referencias != $vulnerabilidad->references){
                        $vuln->referencias = $vulnerabilidad->references;
                    }
                    $vuln->save();
                }
                
            }
        
            return redirect()->route('vulnerabilidades.index')
                        ->with('success',$cant.' vulnerabilidades importadas correctamente');
        } catch (\Exception $ex) {
            return redirect()->route('vulnerabilidades.index')
                        ->with('error','Error al importar las vulnerabilidades');
        }
    }
}
