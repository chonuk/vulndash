@extends('adminlte::page')
@section('css')
<style>
table, thead,tbody,th,td { border: 1px solid gray !important;}
</style>
@endsection
@section('content')
<table class="table table-condensed table-striped table-bordered">
	<thead>
		<th>@sortablelink('nombre','Plataforma')</th>
		<th>@sortablelink('Responsable')</th>
		<th>@sortablelink('activos')</th>
		<th>@sortablelink('vulnerabilidades')</th>
		<th>Detalle</th>
	</thead>
	<tbody>
	@foreach($plataformas as $plataforma)
		<tr>
			<td>{{ $plataforma->nombre }}</td>
			<td>{{ $plataforma->responsable }}</td>
			<td>{{ $plataforma->activos }}</td>
			<td>{{ $plataforma->vulnerabilidades }}</td>
			<td>
				<a class="label label-info" href="{{ route('vulnerabilidades.plataformas',$plataforma->id) }}" data-toggle="tooltip" data-placement="top" title="Ver Detalle"><span class="fa fa-info-circle"></span></a>
			</td>
		</tr>
	@endforeach
	</tbody>
</table>
{{ $links }}
@endsection
@section('js')
<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
@endsection