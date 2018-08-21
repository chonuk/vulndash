@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
               <h3>{{ $vulnerabilidad->nombre }}</h3>
            </div>
            <div class="pull-right">
                <a class="btn btn-sm btn-default" href="{{ URL::previous() }}"><span class="fa fa-chevron-circle-left" aria-hidden="true"></span> Volver</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <h4>
                    <span class="label label-{{ $vulnerabilidad->criticidad->color }}" >{{ $vulnerabilidad->criticidad->texto }}</span>
                    @if($vulnerabilidad->exploit)
                        <span class="label label-danger">Exploit Disponible</span>
                    @endif
                </h4>
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