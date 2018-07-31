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
    <table id="vulns-infra-table" class="table table-condensed table-striped table-bordered">
        <thead>
        <tr>
            <th width="30%">@sortablelink('Nombre')</th>
            <th>@sortablelink('criticidad_id','Criticidad')</th>
            <th>@sortablelink('Protocolo')</th>
            <th>@sortablelink('Exploit')</th>
            <th width="30%">@sortablelink('CVE')</th>
            <th>@sortablelink('salida_parche','Salida Parche')</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($vulnsinfra as $vulninfra)
        <tr>
            <td>{{ $vulninfra->nombre }}</td>
            <td><span class="label label-{{ $vulninfra->criticidad->color }}" >{{ $vulninfra->criticidad->texto }}</span></td>
            <td>{{ $vulninfra->protocolo }}</td>
            <td>{!! $vulninfra->exploit ? '<span class="label label-danger">Si</span>' : '' !!}</td>
            <td>{{ $vulninfra->cve }}</td>
            <td>{{ $vulninfra->salida_parche }}</td>
            <td>
                    <a class="btn btn-sm btn-info" href="{{ route('vulnsinfra.show',$vulninfra->id) }}" data-toggle="tooltip" data-placement="top" title="Ver Detalle"><span class="fa fa-info-circle"></span></a>
                    <a class="btn btn-sm btn-warning" href="{{ route('vulnsinfra.edit',$vulninfra->id) }}" data-toggle="tooltip" data-placement="top" title="Editar Vulnerabilidad"><span class="fa fa-edit"></span></a>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <div class="col-lg-12 margin-tb">
        <div class="col-lg-6">
            <a class="btn btn-sm btn-info" href="{{ route('vulnsinfra.import') }}"> Importar Vulnerabilidades</a>
        </div>
        <div class="pull-right">
            {!! $links !!}
        </div>
    </div>
@endsection