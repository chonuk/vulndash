@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="pull-left">
                <h2> Importar Vulnerabilidades Nessus</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-sm btn-default" href="{{ route('vulnsinfra.index') }}"><span class="fa fa-chevron-circle-left" aria-hidden="true"></span> Volver</a>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="well col-lg-4">
                <strong>Formato: </strong>csv (exportado de Nessus Security Center)<br>
                <strong>Columnas: </strong>
                <ul>
                    <li>Plugin</li>
                    <li>Plugin Name</li>
                    <li>Severity</li>
                    <li>Ip Address</li>
                    <li>Protocol</li>
                    <li>Port</li>
                    <li>Exploit</li>
                    <li>DNS Name</li>
                    <li>NetBIOS Name</li>
                    <li>Plugin Text</li>
                    <li>Synopsis</li>
                    <li>Description</li>
                    <li>Solution</li>
                    <li>See Also</li>
                    <li>CVE</li>
                    <li>First Discovered</li>
                    <li>Last Observed</li>
                    <li>Patch Publication Date</li>
                </ul>
            </div>            
            <form action="{{ route('vulnsinfra.importar') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                    <input type="file" class="form well col-lg-5 col-lg-offset-1" name="fileToUpload" id="fileToUpload" required>
                    <div class="col-lg-4 col-lg-offset-1">
                        <button class="btn btn-sm btn-primary" type="submit"><span class="fa fa-plus" aria-hidden="true"></span> Importar</button>
                    </div>
            </form>
        </div>
    </div>
@endsection