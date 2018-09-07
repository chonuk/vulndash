<?php

namespace App\Http\Controllers;

use App\Activo;
use App\Plataforma;
use Illuminate\Http\Request;

class ActivoController extends Controller
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

        $activos = Activo::with('plataformas:plataforma_id,nombre')->withCount('ocurrencias');

        if($q)
        {
            $activos = $activos->where('ip','like','%'.$q.'%')
                                    ->orWhere('hostname','like','%'.$q.'%');
        }

        if($sort && $order) 
        {
            $activos = $activos->sortable()->orderBy($sort, $order)->paginate(10);
            $links = $activos->appends(['sort' => $sort, 'order' => $order, 'q' => $q])->links();
        }else{
            $activos = $activos->orderBy('hostname','asc')->sortable()->paginate(10);
            $links = $activos->appends(['q' => $q])->links();
        }

        return view('activos.index',compact('activos','links','sort','order','q'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $plataformas = Plataforma::all();
        return view('activos.create', compact('plataformas'));
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
            'ip' => 'required|between:7,15|unique:activos,ip',
        ]);

        $activo = Activo::create($request->except(['plataforma_id']));
        $activo->plataformas()->attach($request->plataforma_id);

        return redirect()->route('activos.index')
                        ->with('success','Activo creada correctamente');
    }

    public function show($id)
    {
        $activo = Activo::find($id);
        $ocurrencias = $activo->ocurrencias()->with('vulnerabilidades.criticidad')->sortable()->get();
        return view('activos.show',compact('activo','ocurrencias'));

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Activo  $activo
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('activos.edit', ['activo' => Activo::findOrFail($id), 'plataformas' => Plataforma::pluck('nombre','id')->all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Activo  $activo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'ip' => 'required|between:7,15|unique:activos,ip,'.$id,
            'plataformas' => 'required',
        ]);
        $activo = Activo::findOrFail($id);
        $activo->update($request->except(['plataformas']));

        $activo->plataformas()->sync($request->get('plataformas'));

        return redirect()->route('activos.index')
                        ->with('success','Activo '. $activo->hostname.' ('.$activo->ip.') actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Activo  $activo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $activo = Activo::findOrFail($id);
        $activo->plataformas()->detach();
        $activo->delete();

        return redirect()->route('activos.index')
                        ->with('success',$activo->ip .'/'.$activo->hostname.' eliminado');
    }

    public function import()
    {
        return view('activos.import');
    }

    public function importar(Request $request)
    {
        if($request->hasFile('fileToUpload')){
            $cant = 0;
            $errPlataforma = 0;
            $errPlataformas = array();
            $errDuplicado = 0;
            $path = $request->file('fileToUpload')->getRealPath();
            $data = \Excel::load($path)->get();

            if($data->count()){
                foreach ($data as $key => $value) {
                    try{
                        $cant++;
                        $plataforma = Plataforma::where('nombre',$value->plataforma)->firstOrFail();
                    }
                    catch(\Exception $e)
                    {
                        $errPlataforma++;
                        $errPlataformas[] = $value->plataforma;
                        continue;
                    }
                    //Busco activo existente o lo crea si no existe
                    $activo = Activo::updateOrCreate(
                        ['ip' => $value->ip],
                        ['hostname' => $value->hostname, 'os' => $value->os]                        
                    );
                    $activo->plataformas()->syncWithoutDetaching($plataforma->id);
                } 
            }
            $array_msg=[];
            if($cant >0)
            {
                $array_msg += ['success' => $cant.' activos importados correctamente'];
            }
            if($errPlataforma > 0)
            {
                $platNES = array_unique($errPlataformas);
                $platNEmsj = '';
                foreach($platNES as $platNE){
                                $platNEmsj .= '<li>'.$platNE.'</li>';
                            }
                $array_msg += ['error' => '<p><strong>'.$errPlataforma.' NO importados:</strong> Plataforma Inexistente</p><p>'.$platNEmsj.'</p>'];
            }

            return redirect()->route('activos.index')
                        ->with($array_msg);
        } 
    }
}
