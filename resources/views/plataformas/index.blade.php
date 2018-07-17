@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a class="btn btn-sm btn-success" href="{{ route('plataformas.create') }}"> Agregar Plataforma</a>&nbsp;
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
            <th>@sortablelink('nombre', 'Web/Aplicacion')</th>
            <th>@sortablelink('tipo')</th>
            <th>@sortablelink('responsable')</th>
            <th width="120px">Accion</th>
        </thead>
        <tbody>
        @foreach ($plataformas as $plataforma)
        <tr>
            <td>{{ $plataforma->id }}</td>
            <td>{{ $plataforma->nombre }}</td>
            <td>{{ $plataforma->tipo }}</td>
            <td>{{ $plataforma->responsable }}</td>
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