@extends('adminlte::page')
@section('css')
<style>
table, thead,tbody,th,td { border: 1px solid blue !important;}
</style>
@endsection
@section('content_header')
<form class="form-inline">
  <div class="form-group">
	<div class="input-group col-md">
    	<div class="input-group-addon">Ip</div>
		<input class="form-control" type="text" readonly value="{{ $activo->ip }}"> 
	</div>
	<div class="input-group">
    	<div class="input-group-addon">Hostname</div>
		<input class="form-control" type="text" readonly value="{{ $activo->hostname }}"> 
	</div>
	<div class="input-group">
    	<div class="input-group-addon">S.O.</div>
		<input class="form-control" type="text" readonly value="{{ $activo->os }}"> 
	</div>
	<div class="input-group">
    	<div class="input-group-addon">Plataformas</div>
	@foreach($activo->plataformas as $plataforma)
	<a class="btn btn-sm btn-default" href="{{ route('plataformas.show',$plataforma->id) }}" >{{ $plataforma->nombre }}</a>
	@endforeach
	</div>
    <span class="col-lg-1 pull-right"><a class="btn btn-sm btn-default" href="{{ URL::previous() }}"><span class="fa fa-chevron-circle-left" aria-hidden="true"></span> Volver</a></span>
  </div>
</form>
@endsection
@section('content')
<table class="table table-condensed table-striped table-borde">
	<thead>
		<th>Vulnerabilidad</th>
		<th>Criticidad</th>
		<th>Exploit</th>
		<th>Fecha de Deteccion</th>
		<th>Estado</th>
	</thead>
	<tbody>

	@foreach($activo->vulnerabilidades as $vulnerabilidad)
		<tr>
			<td>{{ $vulnerabilidad->vulnsinfra->nombre }}</td>
			<td><span class="label label-{{ $vulnerabilidad->vulnsinfra->criticidad->color }}" >{{ $vulnerabilidad->vulnsinfra->criticidad->texto }}</span></td>
			<td>@if($vulnerabilidad->vulnsinfra->exploit)
                    <span class="label label-danger">Disponible</span>
                @endif
			</td>
			<td>{{ $vulnerabilidad->primer_deteccion }}</td>
			<td><span class="label label-{{ $vulnerabilidad->estados->color }}" >{{ $vulnerabilidad->estados->texto }}</span></td>
		</tr>
	@endforeach
	</tbody>
</table>

@endsection
