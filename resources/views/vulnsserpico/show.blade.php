@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
               <h3>{{ $vulnserpico->titulo }}</h3>
            </div>
            <div class="pull-right">
                <a class="btn btn-sm btn-warning" href="{{ route('vulnsserpico.edit',$vulnserpico->id) }}"><span class="fa fa-edit" aria-hidden="true"></span> Editar</a>
                <a class="btn btn-sm btn-default" href="{{ route('vulnsserpico.index') }}"><span class="fa fa-chevron-circle-left" aria-hidden="true"></span> Volver</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <h4><span class="label label-{{ $vulnserpico->criticidad->color }}" >{{ $vulnserpico->criticidad->texto }}</span></h4>
            </div>
        </div>                
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <strong>Descripcion</strong>
                </div>
                <div class="panel-body">
                    {!! nl2br(e($vulnserpico->descripcion)) !!}
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <strong>Remediacion</strong>
                </div>
                <div class="panel-body">
                    {!! nl2br(e($vulnserpico->remediacion)) !!}
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <strong>Referencias</strong>
                </div>
                <div class="panel-body">
                    {!! nl2br(e($vulnserpico->referencias)) !!}
                </div>
            </div>
        </div>
    </div>
@endsection