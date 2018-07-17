@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a class="btn btn-sm btn-success" href="{{ route('vulnerabilidades.create') }}"> Agregar Vulnerabilidad</a>&nbsp;
                <a class="btn btn-sm btn-info" href="{{ route('vulnerabilidades.importar') }}"> Importar Vulnerabilidades</a>
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table table-condensed table-hover" id="vulnerabilidades">
        <thead>
            <th>@sortablelink('id')</th>
            <th>@sortablelink('titulo', 'Vulnerabilidad')</th>
            <th>@sortablelink('criticidad_id', 'criticidad')</th>
            <th width="150px">Accion</th>
        </thead>
        <tbody>
        @foreach ($vulnerabilidades as $vulnerabilidad)
        <tr>
            <td>{{ $vulnerabilidad->id }}</td>
            <td>{{ $vulnerabilidad->titulo }}</td>
            <td><span class="label label-{{ $vulnerabilidad->criticidad->color }}" >{{ $vulnerabilidad->criticidad->texto }}</span></td>
            <td>
                <form action="{{ route('vulnerabilidades.destroy',$vulnerabilidad->id) }}" onsubmit="return ConfirmDelete()" method="POST">
                    <a class="btn btn-sm btn-info" href="{{ route('vulnerabilidades.show',$vulnerabilidad->id) }}" data-toggle="tooltip" data-placement="top" title="Ver Detalle"><span class="fa fa-info-circle"></span></a>
                    <a class="btn btn-sm btn-warning" href="{{ route('vulnerabilidades.edit',$vulnerabilidad->id) }}" data-toggle="tooltip" data-placement="top" title="Editar Vulnerabilidad"><span class="fa fa-edit"></span></a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar Vulnerabilidad"><span class="fa fa-trash"></span></button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <div class="pull-right">
        {!! $links !!}
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