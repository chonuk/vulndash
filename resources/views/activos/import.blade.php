@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="pull-left">
                <h2> Importar Activos</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-sm btn-default" href="{{ route('activos.index') }}"><span class="fa fa-chevron-circle-left" aria-hidden="true"></span> Volver</a>
            </div>
        </div>
        <div class="col-lg-10">
            <div class="well col-lg-8">
                <ul>
                    <li><strong>Formato: </strong>csv</li>
                    <li><strong>Titulos Columnas: </strong>Ip | Hostname | Os | Plataforma</li>
                    <li><strong>Columna 1: </strong><i>Direccion IP</i></li>
                    <li><strong>Columna 2: </strong>Hostname</li>
                    <li><strong>Columna 3: </strong><i>Sistema Operativo</i></li>
                    <li><strong>Columna 4: </strong><i>Plataforma (precargada en el sitio)</i></li>
                </ul>
            </div>            
            <form action="{{ route('activos.importar') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                    <input type="file" class="form well col-lg-8 " name="fileToUpload" id="fileToUpload" required>
                    <div class="col-lg-8">
                        <button class="btn btn-sm btn-primary" type="submit"><span class="fa fa-plus" aria-hidden="true"></span> Importar</button>
                    </div>
            </form>
        </div>
    </div>
@endsection