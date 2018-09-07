@extends('adminlte::page')

@section('searchbar')
<form action="{{ route('vulnerabilidades.index') }}" class="form-inline" method="GET" role="search">
    <div class="form-group">
        <div class="input-group input-group-sm">
            <input type="text" class="form-control" name="q" placeholder="Nombre, CVE o descripcion..." value="{{ $q }}">
            <span class="input-group-btn">
                <button type="submit" class="btn btn-default">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>
    </div>
</form>
@endsection
@section('content')
    <table id="vulnerabilidades-table" class="table table-condensed table-striped table-bordered">
        <thead>
        <tr>
            <th>@sortablelink('Nombre')</th>
            <th>@sortablelink('criticidad_id','Criticidad')</th>
            <th>@sortablelink('Protocolo')</th>
            <th>@sortablelink('Exploit')</th>
            <th>@sortablelink('salida_parche','Salida Parche')</th>
            <th width="120px">Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($vulnerabilidades as $vulnerabilidad)
        <tr>
            <td>{{ $vulnerabilidad->nombre }}</td>
            <td><span class="label label-{{ $vulnerabilidad->criticidad->color }}" >{{ $vulnerabilidad->criticidad->texto }}</span></td>
            <td>{{ $vulnerabilidad->protocolo }}</td>
            <td>{!! $vulnerabilidad->exploit ? '<span class="label label-danger">Si</span>' : '' !!}</td>
            <td>{{ $vulnerabilidad->salida_parche ? $vulnerabilidad->salida_parche->format('d/m/Y') : null }}</td>
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
    <div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="col-lg-6">
            <a class="btn btn-sm btn-info" href="{{ route('vulnerabilidades.import') }}"> Importar Vulnerabilidades</a>
        </div>
        <div class="pull-right">
            {!! $links !!}
        </div>
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