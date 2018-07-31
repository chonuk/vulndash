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
    <table class="table table-condensed table-hover" id="vulnsserpico">
        <thead>
            <th>@sortablelink('id')</th>
            <th>@sortablelink('titulo', 'Vulnerabilidad Serpico')</th>
            <th>@sortablelink('criticidad_id', 'criticidad')</th>
            <th width="150px">Accion</th>
        </thead>
        <tbody>
        @foreach ($vulnsserpico as $vulnserpico)
        <tr>
            <td>{{ $vulnserpico->id }}</td>
            <td>{{ $vulnserpico->titulo }}</td>
            <td><span class="label label-{{ $vulnserpico->criticidad->color }}" >{{ $vulnserpico->criticidad->texto }}</span></td>
            <td>
                <form action="{{ route('vulnsserpico.destroy',$vulnserpico->id) }}" onsubmit="return ConfirmDelete()" method="POST">
                    <a class="btn btn-sm btn-info" href="{{ route('vulnsserpico.show',$vulnserpico->id) }}" data-toggle="tooltip" data-placement="top" title="Ver Detalle"><span class="fa fa-info-circle"></span></a>
                    <a class="btn btn-sm btn-warning" href="{{ route('vulnsserpico.edit',$vulnserpico->id) }}" data-toggle="tooltip" data-placement="top" title="Editar vulnserpico"><span class="fa fa-edit"></span></a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar Vulnerabilidad Serpico"><span class="fa fa-trash"></span></button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table> 
    <div class="col-lg-12">
        <div class="col-lg-6">
            <a class="btn btn-sm btn-success" href="{{ route('vulnsserpico.create') }}"> Agregar Vulnerabilidad Serpico</a>&nbsp;
            <a class="btn btn-sm btn-info" href="{{ route('vulnsserpico.import') }}"> Importar Vulnerabilidades Serpico</a>
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