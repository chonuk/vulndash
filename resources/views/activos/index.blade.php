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
    <table class="table table-condensed table-hover" id="activos">
        <thead>
            <th>@sortablelink('ip')</th>
            <th>@sortablelink('hostname')</th>
            <th>@sortablelink('os')</th>
            <th>Plataformas</th>
            <th>@sortablelink('vulnerabilidades_count','Vulnerabilidades')</th>
            <th width="120px">Accion</th>
        </thead>
        <tbody>
        @foreach ($activos as $activo)
        <tr>
            <td>{{ $activo->ip }}</td>
            <td>{{ $activo->hostname }}</td>
            <td>{{ $activo->os }}</td>
            
            <td> 
                @foreach ($activo->plataformas as $plataforma)
                    <a href="{{ route('plataformas.show',$plataforma->plataforma_id) }}">{{ $plataforma->nombre }}</a>
                    <br>
                @endforeach
            </td>
            <td>{{ $activo->vulnerabilidades_count }}</td>
            <td>
                <form action="{{ route('activos.destroy',$activo->id) }}" onsubmit="return ConfirmDelete()" method="POST">
                    <a class="btn btn-sm btn-info" href="{{ route('activos.show',$activo->id) }}" data-toggle="tooltip" data-placement="top" title="Ver Detalle"><span class="fa fa-info-circle"></span></a>
                    <a class="btn btn-sm btn-warning" href="{{ route('activos.edit',$activo->id) }}" data-toggle="tooltip" data-placement="top" title="Editar Activo"><span class="fa fa-edit"></span></a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar Activo"><span class="fa fa-trash"></span></button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <div class="col-lg-12 margin-tb">
        <div class="col-lg-6">
            <a class="btn btn-sm btn-success" href="{{ route('activos.create') }}"> Agregar Activo</a>&nbsp;
            <a class="btn btn-sm btn-info" href="{{ route('activos.import') }}"> Importar Activos</a>
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
