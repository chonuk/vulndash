@extends('layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Editar Vulnerabilidad</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('vulnerabilidades.index') }}"> Volver</a>
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


    <form action="{{ route('vulnerabilidades.update',$vulnerabilidad->id) }}" method="POST">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Nombre:</strong>
                    <input type="text" name="titulo" value="{{ $vulnerabilidad->titulo }}" class="form-control" placeholder="Titulo">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Criticidad:</strong>
                    <select name="criticidad_id">
                        @foreach ($criticidades as $criticidad) 
                            <option value="{{ $criticidad->id }}"
                            @if ($criticidad->id == $vulnerabilidad->criticidad_id)
                                selected
                            @endif
                            >{{$criticidad->texto}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Descripcion:</strong>
                    <textarea class="form-control" style="height:50px" name="descripcion" placeholder="Descripcion">{{ $vulnerabilidad->descripcion }}</textarea>
                </div>
            </div>            
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Remediacion:</strong>
                    <textarea class="form-control" style="height:50px" name="remediacion" placeholder="Remediacion">{{ $vulnerabilidad->remediacion }}</textarea>
                </div>
            </div>            
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Referencias:</strong>
                    <textarea class="form-control" style="height:50px" name="referencias" placeholder="Referencias">{{ $vulnerabilidad->referencias }}</textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-warning">Enviar</button>
            </div>
        </div>

    </form>

@endsection