@extends('adminlte::page')

@section('searchbar')
<form action="{{ route('activos.index') }}" class="form-inline" method="GET" role="search">
    <div class="form-group">
        <div class="input-group input-group-sm">
            <input type="text" class="form-control" name="q" placeholder="IP u hostname..." value="{{ $q }}">
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
    <table class="table table-condensed table-hover" id="activos">
        <thead>
            <th>@sortablelink('ip')</th>
            <th>@sortablelink('hostname')</th>
            <th>@sortablelink('os')</th>
            <th>Plataformas</th>
            <th>@sortablelink('ocurrencias_count','Vulnerabilidades')</th>
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
            <td>{{ $activo->ocurrencias_count }}</td>
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
    <div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="col-lg-6">
            <a class="btn btn-sm btn-success" href="{{ route('activos.create') }}"> Agregar Activo</a>&nbsp;
            <a class="btn btn-sm btn-info" href="{{ route('activos.import') }}"> Importar Activos</a>
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
