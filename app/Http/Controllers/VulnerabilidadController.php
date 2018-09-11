<?php

namespace App\Http\Controllers;

use App\Vulnerabilidad;
use App\Activo;
use App\Criticidad;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;

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
        $q = $request->input('q');

        $vulnerabilidades = Vulnerabilidad::with('criticidad');

        if($q)
        {
            $vulnerabilidades = $vulnerabilidades->where('nombre','like','%'.$q.'%')
                                    ->orWhere('descripcion','like','%'.$q.'%')
                                    ->orWhere('cve','like','%'.$q.'%');
        }

        if($sort && $order) 
        {
            $vulnerabilidades = $vulnerabilidades->orderBy($sort, $order)->sortable()->paginate(10);
            $links = $vulnerabilidades->appends(['sort' => $sort, 'order' => $order, 'q' => $q])->links();
        }else{
            $vulnerabilidades = $vulnerabilidades->orderBy('criticidad_id','desc')->sortable()->paginate(10);
            $links = $vulnerabilidades->appends(['q' => $q])->links();
        }
        return view('vulnerabilidades.index',compact('vulnerabilidades','links','sort','order','q'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VulnInfra  $vulnInfra
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('vulnerabilidades.show',['vulnerabilidad' => Vulnerabilidad::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VulnInfra  $vulnInfra
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('vulnerabilidades.edit', ['vulnerabilidad' => Vulnerabilidad::findOrFail($id), 'criticidades' => Criticidad::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VulnInfra  $vulnInfra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'plugin' => 'required|unique:vulnerabilidades,plugin,'.$id,
            'criticidad_id' => 'required',
            'descripcion' => 'required',
            'descripcion' => 'required',
            'solucion' => 'required'
        ]);
        $vulnerabilidad = Vulnerabilidad::findOrFail($id);
        $vulnerabilidad->update($request->all());

        return redirect()->route('vulnerabilidades.show', $id)
                        ->with('success','Vulnerabilidad editada.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VulnInfra  $vulnInfra
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vulnerabilidad = Vulnerabilidad::findOrFail($id);
        $vulnerabilidad->activos()->detach();
        $vulnerabilidad->delete();

        return redirect()->route('vulnerabilidades.index')
                        ->with('success','Vulnerabilidad '. $vulnerabilidad->nombre .' eliminada');
    }

    public function import()
    {
        return view('vulnerabilidades.import');
    }

    public function importar(Request $request)
    {
        if($request->hasFile('fileToUpload')){
	    $cant = 0;
	    $duplicadas = 0;
            switch($request->input('tipo')){
            case 'faast':
                request()->validate([
                    'fileToUpload' => 'mimes:csv,txt'
                ]);
                $array_msg = ['error' => '<p><strong>Proximamente en sus Dashboards más cercanos</p>'];
                return redirect()->route('vulnerabilidades.import')
                        ->with($array_msg);
                break;
            case 'nessus':
                request()->validate([
                    'fileToUpload' => 'mimes:csv,txt'
                ]);            
                $path = $request->file('fileToUpload')->getRealPath();
                $data = \Excel::load($path)->get();

                if($data->count()){
                    foreach ($data as $key => $value) {
                        $cant++;

                        switch($value->severity)
                        {
                            case 'Medium':
                                $criticidad = 2;
                                break;
                            case 'High':
                                $criticidad = 3;
                                break;
                            case 'Critical':
                                $criticidad = 4;
                                break;
                        }
                        switch($value->exploit)
                        {
                            case 'Yes':
                                $exploit=1;
                                break;
                            case 'No':
                                $exploit=0;
                                break;
                        }

                        if($value->patch_publication_date <> 'N/A')
                        {
                            $salida_parche = Carbon::createFromFormat('M j, Y H:i:s *', $value->patch_publication_date,'America/Argentina/Buenos_Aires');
                        }
                        else
                        {
                            $salida_parche = null;
                        }
                        try{
                           $primer_deteccion = Carbon::createFromFormat('M j, Y H:i:s *', $value->first_discovered,'America/Argentina/Buenos_Aires');
                            $ultima_deteccion = Carbon::createFromFormat('M j, Y H:i:s *', $value->last_observed,'America/Argentina/Buenos_Aires');
                        }
                        catch(\Exception $e){
                        	$array_msg = ['error' => '<p><strong>Error en formato de archivo</p>'];
                		return redirect()->route('vulnerabilidades.import')
                        		->with($array_msg);    
                        }

                        $vulnerabilidad = Vulnerabilidad::firstOrCreate(
                            ['plugin' => $value->plugin],
                            [
                                'nombre' => $value->plugin_name,
                                'criticidad_id' => $criticidad,
                                'protocolo' => $value->protocol,
                                'exploit' => $exploit,
                                'resumen' => $value->synopsis,
                                'descripcion' => $value->description,
                                'solucion' => $value->solution,
                                'referencias' => $value->see_also,
                                'cve' => $value->cve,
                                'salida_parche' => $salida_parche,
                            ]
                        );

                        if($value->ip_address){    
                            //Busco activo existente o lo crea si no existe
                            $activo = Activo::firstOrCreate(
                                ['ip' => $value->ip_address ],
                                ['hostname' => $value->dns_name ?? $value->netbios_name ]                        
                            );

                            $vulnerabilidad->activos()->syncWithoutDetaching([
                                $activo->id => 
                                [
                                    'puerto' => $value->port,
                                    'primer_deteccion' => $primer_deteccion,
                                    'ultima_deteccion' => $ultima_deteccion,
                                    'estados_id' => 4
                                ]
                            ]);
                        }
                    } 
                }
                break;

            case 'serpico':
                request()->validate([
                    'fileToUpload' => 'mimes:json,txt'
                ]);            
                $path = $request->file('fileToUpload')->store('upload');
                $json = \Storage::disk('local')->get($path);
                \Storage::disk('local')->delete('$path');
                $vulnerabilidades = json_decode($json);
                foreach ($vulnerabilidades as $vulnerabilidad) {
                    //Solo criticidades Criticas, Altas y Medias
                    if($vulnerabilidad->risk < 2){
                        continue;
                    }

                    //Busco por idSerpico
                    $vuln = Vulnerabilidad::where('plugin',$vulnerabilidad->id)->first();
                    $vulnerabilidad->overview = str_replace('</paragraph>',"\r\n",$vulnerabilidad->overview);
                    $vulnerabilidad->overview = str_replace('<paragraph>', '',$vulnerabilidad->overview);
                    $vulnerabilidad->remediation = str_replace('</paragraph>',"\r\n",$vulnerabilidad->remediation);
                    $vulnerabilidad->remediation = str_replace('<paragraph>', '' ,$vulnerabilidad->remediation);
                    $vulnerabilidad->references = str_replace('</paragraph>',"\r\n",$vulnerabilidad->references);
                    $vulnerabilidad->references = str_replace('<paragraph>', '' ,$vulnerabilidad->references);
                
                    //Si no existe se crea
                    if (!$vuln) {
                        $cant++;
                        $new_vuln = new Vulnerabilidad;
                        $new_vuln->plugin = $vulnerabilidad->id;
                        $new_vuln->nombre = $vulnerabilidad->title;
                        $new_vuln->criticidad_id = $vulnerabilidad->risk;
                        $new_vuln->descripcion = $vulnerabilidad->overview;
                        $new_vuln->solucion = $vulnerabilidad->remediation;
                        $new_vuln->referencias = $vulnerabilidad->references;
                        $new_vuln->save();
                    }else{
                        // Si existe sumo duplicadas
                        $duplicadas++;
                    }
                }
                break;
            }

            $array_msg=[];
            if($cant >0)
            {
                $array_msg += ['success' => 'Se importaron '.$cant.' vulnerabilidades'];
            }
            if(($duplicadas)>0)
            {
                $array_msg = ['error' => '<p><strong>Vulnerabilidades duplicadas: </strong>'.$duplicadas.'</p>'];
            }
            return redirect()->route('vulnerabilidades.index')
                        ->with($array_msg);
        } 
    }
}
