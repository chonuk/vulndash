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
    public function index()
    {
        $vulnerabilidades = Vulnerabilidad::with('criticidad')->latest()->paginate(5);

        return view('vulnerabilidades.index',compact('vulnerabilidades'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
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
}
