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


    <table class="table table-condensed table-hovered table-bordered" id="vulnerabilidades">
        <tr>
            <th>@sortablelink('id')</th>
            <th>@sortablelink('titulo', 'Vulnerabilidad')</th>
            <th>@sortablelink('criticidad_id', 'criticidad')</th>
            <th width="280px">Accion</th>
        </tr>
        @foreach ($vulnerabilidades as $vulnerabilidad)
        <tr>
            <td>{{ $vulnerabilidad->id }}</td>
            <td>{{ $vulnerabilidad->titulo }}</td>
            <td>{{ $vulnerabilidad->criticidad->texto }}</td>
            <td>
                <form action="{{ route('vulnerabilidades.destroy',$vulnerabilidad->id) }}" onsubmit="return ConfirmDelete()" method="POST">
                    <a class="btn btn-sm btn-info" href="{{ route('vulnerabilidades.show',$vulnerabilidad->id) }}">Ver</a>
                    <a class="btn btn-sm btn-warning" href="{{ route('vulnerabilidades.edit',$vulnerabilidad->id) }}">Editar</a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    {!! $links !!}


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
@endsection