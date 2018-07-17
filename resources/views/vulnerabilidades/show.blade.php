@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Detalle Vulnerabilidad</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('vulnerabilidades.index') }}"> Volver</a>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Nombre:</strong>
                {{ $vulnerabilidad->titulo }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Criticidad:</strong>
                {{ $vulnerabilidad->criticidad->texto }}
            </div>
        </div>                
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Descripcion:</strong>
                {{ $vulnerabilidad->descripcion }}
            </div>
        </div>        
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Remediacion:</strong>
                {{ $vulnerabilidad->remediacion }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Referencias:</strong>
                {{ $vulnerabilidad->referencias }}
            </div>
        </div>
    </div>
@endsection