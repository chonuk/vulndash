<?php

namespace App\Http\Controllers;

use App\Plataforma;
use Illuminate\Http\Request;

class PlataformaController extends Controller
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
            $plataformas = Plataforma::sortable()->orderBy($sort, $order)->paginate(10);
            $links = $plataformas->appends(['sort' => $sort, 'order' => $order])->links();
        }else{
            $plataformas = Plataforma::orderBy('nombre','asc')->sortable()->paginate(10);
            $links = $plataformas->links();
        }

        return view('plataformas.index',compact('plataformas','links','sort','order'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('plataformas.create');
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
            'nombre' => 'required',
            'tipo' => 'required',
        ]);

        Plataforma::create($request->all());

        return redirect()->route('plataformas.index')
                        ->with('success','Plataforma creada correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Plataforma  $plataforma
     * @return \Illuminate\Http\Response
     */
    public function show(Plataforma $plataforma)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Plataforma  $plataforma
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        return view('plataformas.edit', ['plataforma' => Plataforma::findOrFail($id)]);
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
            'nombre' => 'required',
            'tipo' => 'required',
        ]);
        $plataforma = Plataforma::findOrFail($id);
        $plataforma->update($request->all());


        return redirect()->route('plataformas.index')
                        ->with('success','Plataforma actualizada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Plataforma  $plataforma
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plataforma = Plataforma::findOrFail($id);
        $plataforma->delete();

        return redirect()->route('plataformas.index')
                        ->with('success','Plataforma '. $plataforma->nombre .' eliminada');
    }
}
