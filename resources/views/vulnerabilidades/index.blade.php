@extends('layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Vulnerabilidades - Gestion</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('vulnerabilidades.create') }}"> Crear Vulnerabilidad</a>
                <a class="btn btn-default" href="{{ route('vulnerabilidades.importar') }}"> Importar Vulnerabilidades</a>
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table table-bordered">
        <tr>
            <th>Nro</th>
            <th>Titulo</th>
            <th>Criticidad</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($vulnerabilidades as $vulnerabilidad)
        <tr>
            <td>{{ ++$i }}</td>
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

    {!! $vulnerabilidades->links() !!}


@endsection
@section('js')
  function ConfirmDelete()
  {
  var x = confirm("¿Seguro que desea eliminar el registro?");
  if (x)
    return true;
  else
    return false;
  }
@endsection