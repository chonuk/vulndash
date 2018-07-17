@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Editar Plataforma</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-sm btn-default" href="{{ route('plataformas.index') }}"><span class="fa fa-chevron-circle-left" aria-hidden="true"></span> Volver</a>
            </div>
        </div>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Error!</strong> Hubo un problema con los datos ingresados.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form class="form-horizontal" action="{{ route('plataformas.update',$plataforma->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nombre" class="col-lg-2 col-lg-offset-2" control-label">Nombre</label>
            <div class="col-lg-6">
                <input type="text" id="nombre" name="nombre" class="form-control" value="{{ $plataforma->nombre }}"placeholder="Nombre">
            </div>
        </div>
        <div class="form-group">
            <label for="tipo" class="col-lg-2 col-lg-offset-2" control-label">Tipo</label>
            <div class="col-lg-6">
                <select name="tipo" id="tipo">
                        <option value="Web"
                        @if ($plataforma->tipo == "Web") selected 
                        @endif
                        >Web</option>
                        <option value="Infraestructura"
                        @if ($plataforma->tipo == "Infraestructura") selected 
                        @endif
                        >Infraestructura</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="responsable" class="col-lg-2 col-lg-offset-2" control-label">Responsable</label>
            <div class="col-lg-6">
                 <input type="text" id="responsable" name="responsable" class="form-control" value="{{ $plataforma->responsable }}"placeholder="Responsable">
            </div>
        </div>            
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-sm btn-success"><span class="fa fa-plus" aria-hidden="true"></span>Editar</button>
            </div>
        </div>
    </form>

@endsection