@extends('adminlte::page')

@section('content_header')
    <div class="col-lg-12 margin-tb panel panel-heading">
        <div class="pull-left">
           <h4>{{ $vulnerabilidad->nombre }}</h4>
        </div>
        <div class="pull-right">
            <a class="btn btn-sm btn-warning" href="{{ route('vulnerabilidades.edit',$vulnerabilidad->id) }}" data-toggle="tooltip" data-placement="top" title="Editar Vulnerabilidad"><span class="fa fa-edit"></span> Editar</a>
            <a class="btn btn-sm btn-default" href="javascript:history.back()"><span class="fa fa-chevron-circle-left" aria-hidden="true"></span> Volver</a>
        </div>
    </div>

@endsection
@section('content')
<div class='row'>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <h4>
                <span class="label label-{{ $vulnerabilidad->criticidad->color }}" >{{ $vulnerabilidad->criticidad->texto }}</span>
                @if($vulnerabilidad->exploit)
                    <span class="label label-danger">Exploit Disponible</span>
                @endif
                <span class="pull-right">
                    @if($vulnerabilidad->protocolo)
                        <span class="label label-primary">{{ $vulnerabilidad->protocolo }}</span>
                    @endif
                    @if($vulnerabilidad->salida_parche)
                        <span class="label label-success">Parche publicado {{ $vulnerabilidad->salida_parche->format('d/m/Y') }}</span>
                    @endif
                </span>
            </h4>
        </div>
    </div>                
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <strong>Resumen</strong>
            </div>
            <div class="panel-body">
                {!! nl2br(e($vulnerabilidad->resumen)) !!}
            </div>
        </div>
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
                <strong>Solucion</strong>
            </div>
            <div class="panel-body">
                {!! nl2br(e($vulnerabilidad->solucion)) !!}
            </div>
        </div>
        <div class="panel panel-info">
            <div class="panel-heading">
                <strong>CVE / Referencias</strong>
            </div>
            <div class="panel-body">
                {!! nl2br(e($vulnerabilidad->cve)) !!}
                <hr>
                {!! nl2br(e($vulnerabilidad->referencias)) !!}
            </div>
        </div>
    </div>
</div>
@endsection