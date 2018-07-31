@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="pull-left">
                <h2> Importar Plataformas</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-sm btn-default" href="{{ route('plataformas.index') }}"><span class="fa fa-chevron-circle-left" aria-hidden="true"></span> Volver</a>
            </div>
        </div>
        <div class="col-lg-10">
            <div class="well col-lg-8">
                <ul>
                    <li><strong>Formato: </strong>csv</li>
                    <li><strong>Titulos Columnas: </strong>Nombre | Responsable</li>
                    <li><strong>Columna 1: </strong><i>Nombre Plataforma</i></li>
                    <li><strong>Columna 2: </strong><i>Responsable (opcional)</i></li>
                </ul>
            </div>
            <form action="{{ route('plataformas.importar') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                    <input type="file" class="form well col-lg-8 " name="fileToUpload" id="fileToUpload" required>
                    <div class="col-lg-8">
                        <button class="btn btn-sm btn-primary" type="submit"><span class="fa fa-plus" aria-hidden="true"></span> Importar</button>
                    </div>
            </form>
        </div>
    </div>
@endsection