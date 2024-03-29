@extends('adminlte::page')
@section('css')
<style>
table, thead,tbody,th,td { border: 1px solid blue !important;}
</style>
@endsection
@section('content')
    <table class="table table-condensed table-hover" id="vulnerabilidades">
        <thead>
            <th width="40%">@sortablelink('nombre', 'Web/Plataforma')</th>
            <th width="30%">@sortablelink('responsable')</th>
            <th width="10%">@sortablelink('activos_count','Activos')</th>
            <th width="10%">Accion</th>
        </thead>
        <tbody>
        @foreach ($plataformas as $plataforma)
        <tr>
            <td>{{ $plataforma->nombre }}</td>
            <td>{{ $plataforma->responsable }}</td>
            <td>{{ $plataforma->activos_count }}</td>
            <td>
                <form action="{{ route('plataformas.destroy',$plataforma->id) }}" onsubmit="return ConfirmDelete()" method="POST">
                    <a class="btn btn-sm btn-warning" href="{{ route('plataformas.edit',$plataforma->id) }}" data-toggle="tooltip" data-placement="top" title="Editar Plataforma"><span class="fa fa-edit"></span></a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar Plataforma"><span class="fa fa-trash"></span></button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <div class="col-lg-12 margin-tb">
        <div class="col-lg-6">
            <a class="btn btn-sm btn-success" href="{{ route('plataformas.create') }}"> Agregar Plataforma</a>&nbsp;
            <a class="btn btn-sm btn-info" href="{{ route('plataformas.import') }}"> Importar Plataforma</a>
        </div>
        <div class="pull-right">
            {!! $links !!}
        </div>
    </div>
@endsection
@section('js')
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