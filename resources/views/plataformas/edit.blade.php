@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Editar Plataforma</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-sm btn-default" href="{{ route('plataformas.index') }}"><span class="fa fa-chevron-circle-left" aria-hidden="true"></span> Volver</a>
            </div>
        </div>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Error!</strong> Hubo un problema con los datos ingresados.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form class="form-inline" action="{{ route('plataformas.update',$plataforma->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group col-lg-12 well well-sm">
            <label for="nombre" class="col-lg-1" control-label">Nombre</label>
            <div class="col-lg-3">
                <input type="text" id="nombre" name="nombre" class="form-control" value="{{ $plataforma->nombre }}"placeholder="Nombre">
            </div>
            <label for="responsable" class="col-lg-1" control-label">Responsable</label>
            <div class="col-lg-2">
                 <input type="text" id="responsable" name="responsable" class="form-control" value="{{ $plataforma->responsable }}"placeholder="Responsable">
            </div>
            <div class="col-sm-1">
                <button type="submit" class="btn btn-sm btn-success"><span class="fa fa-plus" aria-hidden="true"></span>Editar</button>
            </div>
        </div>
    </form>
    <hr>
     <table class="table table-condensed table-hover" id="activos">
        <thead>
            <th>@sortablelink('ip')</th>
            <th>@sortablelink('hostname')</th>
            <th>@sortablelink('os')</th>
            <th width="120px">Accion</th>
        </thead>
        <tbody>
        @foreach ($activos as $activo)
        <tr>
            <td>{{ $activo->ip }}</td>
            <td>{{ $activo->hostname }}</td>
            <td>{{ $activo->os }}</td>
            <td>
                <form action="{{ route('plataformas.detach',$plataforma->id)}}" onsubmit="return ConfirmDelete()" method="POST">
                    <a class="btn btn-sm btn-warning" href="{{ route('activos.edit',$activo->id) }}" data-toggle="tooltip" data-placement="top" title="Editar Activo"><span class="fa fa-edit"></span></a>
                    @csrf
                    <input type="hidden" name="activo_id" value="{{ $activo->id }}">
                    <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Quitar Activo de Plataforma"><span class="fa fa-trash"></span></button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <span class="pull-right">{{ $links }}</span>
   

@endsection
@section('js')
<script>
  function ConfirmDelete()
  {
  var x = confirm("¿Seguro que desea quitar el activo de la plataforma?");
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