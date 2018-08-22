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
    public function index(Request $request)
    {
        $sort = $request->input('sort'); 
        $order = $request->input('order');

        if($sort && $order) 
        {
            $ocurrencias = Ocurrencia::with('vulnerabilidades.criticidad','estados')->sortable()->orderBy($sort, $order)->paginate(10);
            $links = $ocurrencias->appends(['sort' => $sort, 'order' => $order])->links();
        }else{
            $ocurrencias = Ocurrencia::with('vulnerabilidades.criticidad','estados')->orderBy('criticidad_id','desc')->sortable()->paginate(10);
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
