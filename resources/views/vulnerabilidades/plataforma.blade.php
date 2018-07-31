@extends('adminlte::page')
@section('css')
<style>
table, thead,tbody,th,td { border: 1px solid blue !important;}
</style>
@endsection
@section('content')
<div class="col-lg-12 well well-sm">
	<span class="col-lg-4"><h4>{{ $plataforma->nombre }}</h4></span>
	<span class="col-lg-6"><h5>Responsable: {{ $plataforma->responsable }}</h5></span>
    <span class="col-lg-1 pull-right"><a class="btn btn-sm btn-default" href="{{ route('vulnerabilidades.plataformas') }}"><span class="fa fa-chevron-circle-left" aria-hidden="true"></span> Volver</a></span>
</div>
<table class="table table-condensed table-striped table-borde">
	<thead>
		<th>Nombre</th>
		<th>Criticidad</th>
		<th>Exploit</th>
		<th width="450px;">Targets</th>
	</thead>
	<tbody>

	@foreach($vulnsinfra as $vulninfra)
		<tr>
			<td>{{ $vulninfra->nombre }}</td>
			<td><span class="label label-{{ $vulninfra->criticidad->color }}" >{{ $vulninfra->criticidad->texto }}</span></td>
			<td>@if($vulninfra->exploit)
                    <span class="label label-danger">Disponible</span>
                @endif
			</td>
			<td>
				@foreach($plataforma->activos as $activo)
					@foreach($activo->vulnerabilidades as $vulnerabilidad)
						@if($vulnerabilidad->vulnsinfra_id == $vulninfra->id)
							<span class="label label-default">{{ $activo->hostname }}</span><span class="label label-info">{{ $activo->ip }}:{{ $vulnerabilidad->puerto }}</span>
							<span class="label label-success"><a style="color: white;" href="#">Marcar corregido</a></span><br>
						@endif
					@endforeach
				@endforeach
			</td>
		</tr>
	@endforeach
	</tbody>
</table>

@endsection