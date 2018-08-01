<?php

namespace App\Http\Controllers;

use App\Vulnerabilidad;
use App\Plataforma;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Database\Eloquent\Collection;

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
            $vulnerabilidades = Vulnerabilidad::with('vulnsinfra.criticidad','estados')->sortable()->orderBy($sort, $order)->paginate(10);
            $links = $vulnerabilidades->appends(['sort' => $sort, 'order' => $order])->links();
        }else{
            $vulnerabilidades = Vulnerabilidad::with('vulnsinfra.criticidad','estados')->orderBy('criticidad_id','desc')->sortable()->paginate(10);
            $links = $vulnerabilidades->links();
        }

        return view('vulnerabilidades.index',compact('vulnerabilidades','links','sort','order'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function plataformas(Request $request, $id = 0)
    {
        $sort = $request->input('sort'); 
        $order = $request->input('order');

        if($id == 0)
        {
            if($sort && $order) 
            {
                $plataformas = Plataforma::leftJoin('activo_plataforma','plataformas.id','=','activo_plataforma.plataforma_id')
                        ->leftJoin('vulnerabilidades','activo_plataforma.activo_id','=','vulnerabilidades.activos_id')
                            ->groupBy('plataformas.id','plataformas.nombre','plataformas.responsable')
                            ->select('plataformas.id','plataformas.nombre','plataformas.responsable')
                        ->selectRaw('count(vulnerabilidades.vulnsinfra_id) as vulnerabilidades')
                        ->selectRaw('count(distinct activo_plataforma.activo_id) as activos')
                        ->orderBy($sort, $order)->sortable()->paginate(12);
                $links = $plataformas->appends(['sort' => $sort, 'order' => $order])->links();
            }
            else
            {
                $plataformas = Plataforma::leftJoin('activo_plataforma','plataformas.id','=','activo_plataforma.plataforma_id')
                        ->leftJoin('vulnerabilidades','activo_plataforma.activo_id','=','vulnerabilidades.activos_id')
                            ->groupBy('plataformas.id','plataformas.nombre','plataformas.responsable')
                            ->select('plataformas.id','plataformas.nombre','plataformas.responsable')
                        ->selectRaw('count(vulnerabilidades.vulnsinfra_id) as vulnerabilidades')
                        ->selectRaw('count(distinct activo_plataforma.activo_id) as activos')
                        ->orderBy('nombre', 'asc')->sortable()->paginate(12);
                $links = $plataformas->links();
            }

            return view('vulnerabilidades.plataformas',compact('plataformas','links','sort','order'))
                    ->with('i', (request()->input('page', 1) - 1) * 10);
        }
        else
        {
            $plataforma = Plataforma::with('activos.vulnsinfra','activos.vulnerabilidades')->find($id);

            $vulnArray = $plataforma->activos->pluck('vulnsinfra'); 
            $vulnsinfra = (new Collection($vulnArray))->collapse()->unique('id')->sortByDesc('criticidad_id');
            #dd($plataforma->activos);
            return view('vulnerabilidades.plataforma',compact('vulnsinfra','plataforma'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
        }
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
     * @param  \App\Vulnerabilidad  $vulnerabilidad
     * @return \Illuminate\Http\Response
     */
    public function show(Vulnerabilidad $vulnerabilidad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vulnerabilidad  $vulnerabilidad
     * @return \Illuminate\Http\Response
     */
    public function edit(Vulnerabilidad $vulnerabilidad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vulnerabilidad  $vulnerabilidad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vulnerabilidad $vulnerabilidad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vulnerabilidad  $vulnerabilidad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vulnerabilidad $vulnerabilidad)
    {
        //
    }
}
