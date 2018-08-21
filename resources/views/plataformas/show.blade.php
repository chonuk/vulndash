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
    	<div class="input-group-addon">Nombre</div>
		<input class="form-control" type="text" readonly value="{{ $plataforma->nombre }}"> 
	</div>
	<div class="input-group col-md">
    	<div class="input-group-addon">Responsable</div>
		<input class="form-control" type="text" readonly value="{{ $plataforma->responsable }}"> 
	</div>
    <span class="col-lg-1 pull-right"><a class="btn btn-sm btn-default" href="{{ URL::previous() }}"><span class="fa fa-chevron-circle-left" aria-hidden="true"></span> Volver</a></span>
  </div>
</form>
@endsection
@section('content')
<table class="table table-condensed table-striped table-borde">
	<thead>
		<th>Nombre</th>
		<th>Criticidad</th>
		<th>Exploit</th>
		<th width="450px;">Targets</th>
	</thead>
	<tbody>

	@foreach($vulnerabilidades as $vulnerabilidad)
		<tr>
			<td>{{ $vulnerabilidad->nombre }}</td>
			<td><span class="label label-{{ $vulnerabilidad->criticidad->color }}" >{{ $vulnerabilidad->criticidad->texto }}</span></td>
			<td>@if($vulnerabilidad->exploit)
                    <span class="label label-danger">Disponible</span>
                @endif
			</td>
			<td>
				@foreach($plataforma->activos as $activo)
					@foreach($activo->ocurrencias as $ocurrencia)
						@if($ocurrencia->vulnerabilidad_id == $vulnerabilidad->id)
							<strong>Ip: </strong>{{ $activo->ip }} - <strong>Puerto: </strong>{{ $ocurrencia->puerto }}
							<span class="label label-success pull-right">
								<a style="color: white;" href="#">Marcar Corregido</a>
							</span>
							<span class="label label-info pull-right">
								<a style="color: white;" href="#">Ver detalle</a>
							</span>
							<br>
						@endif
					@endforeach
				@endforeach
			</td>
		</tr>
	@endforeach
	</tbody>
</table>

@endsection