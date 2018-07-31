<?php

namespace App\Http\Controllers;

use App\VulnInfra;
use App\Activo;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class VulnInfraController extends Controller
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
            $vulnsinfra = VulnInfra::with('criticidad')->sortable()->orderBy($sort, $order)->paginate(10);
            $links = $vulnsinfra->appends(['sort' => $sort, 'order' => $order])->links();
        }else{
            $vulnsinfra = VulnInfra::with('criticidad')->orderBy('criticidad_id','desc')->sortable()->paginate(10);
            $links = $vulnsinfra->links();
        }

        return view('vulnsinfra.index',compact('vulnsinfra','links','sort','order'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    // public function data(Datatables $datatables)
    // {
    //     $query = VulnInfra::with('criticidad','activos.plataformas');

    //     return $datatables->eloquent($query)
    //                       ->rawColumns(['action'])
    //                       ->make(true);
    // }

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
        return view('vulnsinfra.show',['vulninfra' => VulnInfra::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VulnInfra  $vulnInfra
     * @return \Illuminate\Http\Response
     */
    public function edit(VulnInfra $vulnInfra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VulnInfra  $vulnInfra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VulnInfra $vulnInfra)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VulnInfra  $vulnInfra
     * @return \Illuminate\Http\Response
     */
    public function destroy(VulnInfra $vulnInfra)
    {
        //
    }

    public function import()
    {
        return view('vulnsinfra.import');
    }

    public function importar(Request $request)
    {
        if($request->hasFile('fileToUpload')){
            $cant = 0;
            $path = $request->file('fileToUpload')->getRealPath();
            $data = \Excel::load($path)->get();

            if($data->count()){
                foreach ($data as $key => $value) {
                    $cant++;
                    //Busco activo existente o lo crea si no existe
                    $activo = Activo::firstOrCreate(
                        ['ip' => $value->ip_address ],
                        ['hostname' => $value->dns_name ?? $value->netbios_name ]                        
                    );
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
                    $vulninfra = VulnInfra::firstOrCreate(
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
                            'salida_parche' => $value->patch_publication_date
                        ]
                    );
                    $vulninfra->activos()->syncWithoutDetaching([
                        $activo->id => 
                        [
                            'puerto' => $value->port,
                            'primer_deteccion' => $value->first_discovered,
                            'ultima_deteccion' => $value->last_observed,
                            'estados_id' => 4
                        ]
                    ]);
                } 
            }
            $array_msg=[];
            if($cant >0)
            {
                $array_msg += ['success' => 'Se importaron '.$cant.' vulnerabilidades de Infraestructura'];
            }
            return redirect()->route('activos.index')
                        ->with($array_msg);
        } 
    }
}
