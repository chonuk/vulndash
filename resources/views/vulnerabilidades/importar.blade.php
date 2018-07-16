@extends('layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Importar Vulnerabilidades</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('vulnerabilidades.index') }}"> Volver</a>
            </div>
        </div>
    </div>
@endsection