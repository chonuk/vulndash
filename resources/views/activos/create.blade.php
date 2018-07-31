@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Crear Activo</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-sm btn-default" href="{{ route('activos.index') }}"><span class="fa fa-chevron-circle-left" aria-hidden="true"></span> Volver</a>
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


    <form class="form-horizontal" action="{{ route('activos.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="ip" class="col-lg-2 col-lg-offset-2" control-label">Ip</label>
            <div class="col-lg-6">
                <input type="text" id="ip" name="ip" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label for="hostname" class="col-lg-2 col-lg-offset-2" control-label">Hostname</label>
            <div class="col-lg-6">
                 <input type="text" id="hostname" name="hostname" class="form-control">
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="os" class="col-lg-2 col-lg-offset-2" control-label">Sistema Operativo</label>
            <div class="col-lg-6">
                <input type="text" id="os" name="os" class="form-control">
            </div>
        </div>            
        <div class="form-group">
            <label for="plataforma" class="col-lg-2 col-lg-offset-2" control-label">Plataforma</label>
            <div class="col-lg-6">
                <select name="plataforma_id" id="plataforma">
                    @if($plataformas)
                        @foreach ($plataformas as $plataforma)
                            <option value="{{ $plataforma->id }}">{{$plataforma->nombre}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>            
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-sm btn-success"><span class="fa fa-plus" aria-hidden="true"></span>Agregar</button>
            </div>
        </div>
    </form>

@endsection