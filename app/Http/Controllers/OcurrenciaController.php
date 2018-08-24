<?php

namespace App\Http\Controllers;

use App\Vulnerabilidad;
use App\Ocurrencia;
use App\Plataforma;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Database\Eloquent\Collection;

class OcurrenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $sort = $request->input('sort'); 
        $order = $request->input('order');

        if($sort && $order) 
        {
            $ocurrencias = Ocurrencia::leftJoin('estados', 'estados_id','=', 'estados.id')
                ->leftJoin('vulnerabilidades','vulnerabilidades_id','=', 'vulnerabilidades.id')
                ->leftJoin('criticidades', 'vulnerabilidades.criticidad_id','=', 'criticidades.id')
                ->leftJoin('activo_plataforma','activos_id','=','activo_plataforma.activo_id')
                ->leftJoin('plataformas','activo_plataforma.plataforma_id','=','plataformas.id')
                ->select('ocurrencias.id','vulnerabilidades.id as vulnerabilidad_id','vulnerabilidades.nombre as vulnerabilidad_nombre','criticidad_id','criticidades.texto as criticidad_texto', 'criticidades.color as criticidad_color', 'estados.texto as estado_texto','estados.color as estado_color','plataformas.id as plataforma_id', 'plataformas.nombre as plataforma_nombre')
                ->selectRaw('count(activos_id) as activos')
                ->groupBy('vulnerabilidad_id','vulnerabilidad_nombre','plataforma_id','plataforma_nombre')
                ->orderByRaw($sort.' COLLATE NOCASE '.$order)->sortable()->paginate(10);
        $links = $ocurrencias->appends(['sort' => $sort, 'order' => $order])->links();
        }
        else
        {
            $ocurrencias = Ocurrencia::leftJoin('estados', 'estados_id','=', 'estados.id')
                ->leftJoin('vulnerabilidades','vulnerabilidades_id','=', 'vulnerabilidades.id')
                ->leftJoin('criticidades', 'vulnerabilidades.criticidad_id','=', 'criticidades.id')
                ->leftJoin('activo_plataforma','activos_id','=','activo_plataforma.activo_id')
                ->leftJoin('plataformas','activo_plataforma.plataforma_id','=','plataformas.id')
                ->select('ocurrencias.id','vulnerabilidades.id as vulnerabilidad_id','vulnerabilidades.nombre as vulnerabilidad_nombre','criticidad_id','criticidades.texto as criticidad_texto', 'criticidades.color as criticidad_color', 'estados.texto as estado_texto','estados.color as estado_color','plataformas.id as plataforma_id', 'plataformas.nombre as plataforma_nombre')
                ->selectRaw('count(activos_id) as activos')
                ->groupBy('vulnerabilidad_id','vulnerabilidad_nombre','plataforma_id','plataforma_nombre')
                ->orderByRaw('criticidad_id desc, activos asc')->sortable()->paginate(10);
            $links = $ocurrencias->links();
        }
#dd($ocurrencias);
        return view('ocurrencias.index',compact('ocurrencias','links','sort','order'))
                ->with('i', (request()->input('page', 1) - 1) * 1000);
    }

    public function index2(Request $request)
    {
        $sort = $request->input('sort'); 
        $order = $request->input('order');

        if($sort && $order) 
        {
            $ocurrencias = Ocurrencia::with('vulnerabilidades.criticidad','estados','activos')->sortable()->orderBy($sort, $order)->paginate(10);
            $links = $ocurrencias->appends(['sort' => $sort, 'order' => $order])->links();
        }else{
            $ocurrencias = Ocurrencia::with('vulnerabilidades.criticidad','estados','activos')->orderBy('criticidad_id','desc')->sortable()->paginate(10);
            $links = $ocurrencias->links();
        }

        return view('ocurrencias.index',compact('ocurrencias','links','sort','order'))
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
