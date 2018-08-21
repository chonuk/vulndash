@extends('adminlte::page')

@section('content')
    @if ($message_ok = Session::get('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
            </button>
            <p>{{ $message_ok }}</p>
        </div>
    @endif
    @if ($message_error = Session::get('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
            </button>
            <p>{!! $message_error !!}</p>
        </div>
    @endif
    <table id="vulnerabilidades-table" class="table table-condensed table-striped table-bordered">
        <thead>
        <tr>
            <th width="30%">@sortablelink('Nombre')</th>
            <th>@sortablelink('criticidad_id','Criticidad')</th>
            <th>@sortablelink('Protocolo')</th>
            <th>@sortablelink('Exploit')</th>
            <th width="30%">@sortablelink('CVE')</th>
            <th>@sortablelink('salida_parche','Salida Parche')</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($vulnerabilidades as $vulnerabilidad)
        <tr>
            <td>{{ $vulnerabilidad->nombre }}</td>
            <td><span class="label label-{{ $vulnerabilidad->criticidad->color }}" >{{ $vulnerabilidad->criticidad->texto }}</span></td>
            <td>{{ $vulnerabilidad->protocolo }}</td>
            <td>{!! $vulnerabilidad->exploit ? '<span class="label label-danger">Si</span>' : '' !!}</td>
            <td>{{ $vulnerabilidad->cve }}</td>
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
    <div class="col-lg-12 margin-tb">
        <div class="col-lg-6">
            <a class="btn btn-sm btn-info" href="{{ route('vulnerabilidades.import') }}"> Importar Vulnerabilidades</a>
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