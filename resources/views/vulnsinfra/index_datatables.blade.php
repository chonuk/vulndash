@extends('adminlte::page')

@section('content')
    @if ($message_ok = Session::get('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
            </button>
            <p>{{ $message_ok }}</p>
        </div>
    @endif
    @if ($message_error = Session::get('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
            </button>
            <p>{!! $message_error !!}</p>
        </div>
    @endif
   <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a class="btn btn-sm btn-info" href="{{ route('vulnsinfra.import') }}"> Importar Activos</a>
                <br><br>
            </div>
        </div>
    </div>
    <table id="vulns-infra-table" class="table table-condensed table-striped table-bordered">
        <thead>
        <tr>
            <th>Nombre</th>
            <th>Criticidad</th>
            <th>Plataforma</th>
            <th>Ip</th>
            <th>Hostname</th>
            <th>Protocolo</th>
            <th>Puerto</th>
            <th>Exploit</th>
            <th>Primer Deteccion</th>
            <th>Ultima Deteccion</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        </thead>
    </table>

@endsection
@section('js')
<script>
    $(function () {
        $('#vulns-infra-table').DataTable({
            serverSide: true,
            processing: true,
            ajax: '/vulnsinfra/index-data',
            columns: [
                {data: 'nombre'},
                {data: 'criticidad.texto'},
                {data: 'activos.plataformas.nombre'},
                {data: 'activos.[0].ip'},
                {data: 'activos.hostname'},
                {data: 'protocolo'},
                {data: 'pivot.puerto'},
                {data: 'exploit'},
                {data: 'pivot.primer_deteccion'},
                {data: 'pivot.ultima_deteccion'},
                {data: 'texto'},
                {data: 'action', orderable: false, searchable: false}
            ],
            buttons: [
                    'csv', 'excel', 'pdf',
                ]
        });
    });
</script>
@endsection