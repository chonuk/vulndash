@extends('adminlte::page')
@section('content_header')

<form class="form-inline">
  <div class="form-group">
	<div class="input-group col-md-2">
    	<div class="input-group-addon">Ip</div>
		<input class="form-control" type="text" readonly value="{{ $activo->ip }}"> 
	</div>
	<div class="input-group col-md-3">
    	<div class="input-group-addon">Hostname</div>
		<input class="form-control" type="text" readonly value="{{ $activo->hostname }}"> 
	</div>
	<div class="input-group col-md-3">
    	<div class="input-group-addon">S.O.</div>
		<input class="form-control" type="text" readonly value="{{ $activo->os }}"> 
	</div>
	<div class="input-group">
    	<div class="input-group-addon">Plataformas</div>
	@foreach($activo->plataformas as $plataforma)
	<a class="btn btn-sm btn-default" href="{{ route('plataformas.show',$plataforma->id) }}" >{{ $plataforma->nombre }}</a>
	@endforeach
	</div>
    <span class="col-lg-1 pull-right"><a class="btn btn-sm btn-default" href="javascript:history.back()"><span class="fa fa-chevron-circle-left" aria-hidden="true"></span> Volver</a></span>
	<a class="pull-right btn btn-sm btn-warning" href="{{ route('activos.edit',$activo->id) }}" data-toggle="tooltip" data-placement="top" title="Editar Activo"><span class="fa fa-edit"></span> Editar</a>
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

	@foreach($activo->ocurrencias as $ocurrencia)
		<tr>
			<td>{{ $ocurrencia->vulnerabilidades->nombre }}</td>
			<td><span class="label label-{{ $ocurrencia->vulnerabilidades->criticidad->color }}" >{{ $ocurrencia->vulnerabilidades->criticidad->texto }}</span></td>
			<td>@if($ocurrencia->vulnerabilidades->exploit)
                    <span class="label label-danger">Disponible</span>
                @endif
			</td>
			<td>{{ $ocurrencia->primer_deteccion->format('d/m/Y') }}</td>
			<td><span class="label label-{{ $ocurrencia->estados->color }}" >{{ $ocurrencia->estados->texto }}</span></td>
		</tr>
	@endforeach
	</tbody>
</table>

@endsection
