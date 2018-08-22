@extends('adminlte::page')

@section('content')
<table class="table table-condensed table-striped table-bordered">
	<thead>
		<th>@sortablelink('nombre','Plataforma')</th>
		<th>@sortablelink('Responsable')</th>
		<th>@sortablelink('activos')</th>
		<th>@sortablelink('vulnerabilidades')</th>
	</thead>
	<tbody>
	@foreach($plataformas as $plataforma)
		<tr>
			<td><a href="{{ route('plataformas.show',$plataforma->id) }}">{{ $plataforma->nombre }}</a></td>
			<td>{{ $plataforma->responsable }}</td>
			<td>{{ $plataforma->activos }}</td>
			<td>{{ $plataforma->vulnerabilidades }}</td>
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
<script>
  function ConfirmDelete()
  {
  var x = confirm("¿Seguro que desea eliminar el registro?");
  if (x)
    return true;
  else
    return false;
  }
</script>
<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
@endsection