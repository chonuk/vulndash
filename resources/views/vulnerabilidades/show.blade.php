@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
               <h3>{{ $vulnerabilidad->titulo }}</h3>
            </div>
            <div class="pull-right">
                <a class="btn btn-sm btn-warning" href="{{ route('vulnerabilidades.edit',$vulnerabilidad->id) }}"><span class="fa fa-edit" aria-hidden="true"></span> Editar</a>
                <a class="btn btn-sm btn-default" href="{{ route('vulnerabilidades.index') }}"><span class="fa fa-chevron-circle-left" aria-hidden="true"></span> Volver</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <h4><span class="label label-{{ $vulnerabilidad->criticidad->color }}" >{{ $vulnerabilidad->criticidad->texto }}</span></h4>
            </div>
        </div>                
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <strong>Descripcion</strong>
                </div>
                <div class="panel-body">
                    {!! nl2br(e($vulnerabilidad->descripcion)) !!}
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <strong>Remediacion</strong>
                </div>
                <div class="panel-body">
                    {!! nl2br(e($vulnerabilidad->remediacion)) !!}
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <strong>Referencias</strong>
                </div>
                <div class="panel-body">
                    {!! nl2br(e($vulnerabilidad->referencias)) !!}
                </div>
            </div>
        </div>
    </div>
@endsection