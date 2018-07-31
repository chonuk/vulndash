<?php

namespace App\Http\Controllers;

use App\Plataforma;
use App\TipoPlataforma;
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
            $plataformas = Plataforma::withCount('activos')->sortable()->orderBy($sort, $order)->paginate(10);
            $links = $plataformas->appends(['sort' => $sort, 'order' => $order])->links();
        }else{
            $plataformas = Plataforma::withCount('activos')->orderBy('vulnerabilidades','desc')->sortable()->paginate(10);
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
            'nombre' => 'required|unique:plataformas,nombre',
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
        // Ver Detalle de la plataforma con sus activos
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Plataforma  $plataforma
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {   
        $plataforma = Plataforma::find($id);

        $sort = $request->input('sort'); 
        $order = $request->input('order');
        
        if($sort && $order) 
        {
            $activos = $plataforma->activos()->sortable()->orderBy($sort, $order)->paginate(7);
            $links = $activos->appends(['sort' => $sort, 'order' => $order])->links();
        }else{
            $activos = $plataforma->activos()->orderBy('ip','asc')->sortable()->paginate(7);
            $links = $activos->links();
        }

        return view('plataformas.edit', compact('plataforma','activos','links','sort','order'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
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
            'nombre' => 'required|unique:plataformas,nombre,'.$id,
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
        $plataforma->activos()->detach();
        $plataforma->delete();

        return redirect()->route('plataformas.index')
                        ->with('success','Plataforma '. $plataforma->nombre .' eliminada');
    }

    public function import()
    {
        return view('plataformas.import');
    }

    public function importar(Request $request){
        if($request->hasFile('fileToUpload')){
            $cant = 0;
            $errDuplicado = 0;
            $path = $request->file('fileToUpload')->getRealPath();
            $data = \Excel::load($path)->get();

            if($data->count()){
                foreach ($data as $key => $value) {
                    //Busco plataforma existente
                    $plataforma = Plataforma::where('nombre',$value->nombre)->first();
                    if (!$plataforma) {
                        $cant++;
                        $arr[] = [
                            'nombre' => $value->nombre, 
                            'responsable' => $value->responsable
                        ];
                    }
                    else
                    {
                        $errDuplicado++;
                    }
                }
            }
            try
            {
                if(!empty($arr)){
                   \DB::table('plataformas')->insert($arr);
                }
            }
            catch(\Illuminate\Database\QueryException $e)
            {
                return redirect()->route('plataformas.index')
                            ->with('error', 'Plataformas duplicadas en el archivo a subir, por favor validar.');
            }
            $array_msg=[];
            if($cant >0)
            {
                $array_msg += ['success' => '<strong>'.$cant.' plataformas importadas correctamente</strong>'];
            }
            if(($errDuplicado)>0)
            {
                $array_msg += ['error' => '<p><strong>Plataformas NO importadas</strong></p> <p>Plataformas Duplicadas: '.$errDuplicado.'</p>'];
            }
            return redirect()->route('plataformas.index')
                ->with($array_msg);
        }
        else
        {
            return redirect()->route('plataformas.index')
                ->with('error','Error al subir el archivo');
        }
    } 

    public function detach($id, Request $request)
    {
        $plataforma = Plataforma::find($id);

        $plataforma->activos()->detach($request->input('activo_id'));
        return redirect()->route('plataformas.edit', $plataforma)->with('success', 'Se elimino el activo');
    }
}
