@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="pull-left">
                <h2> Importar Vulnerabilidades</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-sm btn-default" href="{{ route('vulnerabilidades.index') }}"> Volver</a>
            </div>
        </div>
        <div class="col-lg-10">
            <form action="{{ route('vulnerabilidades.import') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                    <input type="file" class="form well col-lg-6 " name="fileToUpload" id="fileToUpload" required>
                    <div class="col-lg-12">
                        <button class="btn btn-sm btn-primary" type="submit"><span class="fa fa-plus" aria-hidden="true"></span> Importar Vulnerabilidades</button>
                    </div>
            </form>
        </div>
    </div>
@endsection