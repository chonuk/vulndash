@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Crear Plataforma</h2>
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


    <form class="form-horizontal" action="{{ route('plataformas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nombre" class="col-lg-2 col-lg-offset-2" control-label">Web/Aplicacion</label>
            <div class="col-lg-6">
                <input type="text" id="nombre" name="nombre" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label for="tipo" class="col-lg-2 col-lg-offset-2" control-label">Tipo</label>
            <div class="col-lg-6">
                <select name="tipo" id="tipo">
                        <option value="Web">Web</option>
                        <option value="Infraestructura">Infraestructura</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="responsable" class="col-lg-2 col-lg-offset-2" control-label">Responsable</label>
            <div class="col-lg-6">
                <input type="text" id="responsable" name="responsable" class="form-control">
            </div>
        </div>            
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-sm btn-success"><span class="fa fa-plus" aria-hidden="true"></span>Agregar</button>
            </div>
        </div>
    </form>

@endsection