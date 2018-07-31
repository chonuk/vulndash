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
    <table id="vulnerabilidades-table" class="table table-condensed table-striped table-bordered">
        <thead>
        <tr>
            <th width="30%">@sortablelink('vulnsinfra.nombre','Nombre')</th>
            <th>@sortablelink('vulnsinfra.criticidad_id','Criticidad')</th>
            <th>@sortablelink('activos_count','Activos')</th>
            <th>@sortablelink('vulnsinfra.exploit')</th>
            <th>@sortablelink('primer_deteccion','Primer Deteccion')</th>
            <th>@sortablelink('estados.texto','Estado')</th>
            <th width="100px">Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($vulnerabilidades as $vulnerabilidad)
        <tr>
            <td>{{ $vulnerabilidad->vulnsinfra->nombre }}</td>
            <td><span class="label label-{{ $vulnerabilidad->vulnsinfra->criticidad->color }}" >{{ $vulnerabilidad->vulnsinfra->criticidad->texto }}</span></td>
            <td>{{ $vulnerabilidad->activos_count }}</td>
            <td>{{ $vulnerabilidad->vulnsinfra->exploit ? 'Si' : '-' }}</td>
            <td>{{ $vulnerabilidad->primer_deteccion }}</td>
            <td>{{ $vulnerabilidad->estados->texto }}</td>
            <td>
                <a class="btn btn-sm btn-info" href="{{ route('vulnerabilidades.show',$vulnerabilidad->id) }}" data-toggle="tooltip" data-placement="top" title="Ver Detalle"><span class="fa fa-info-circle"></span></a>
                <a class="btn btn-sm btn-warning" href="{{ route('vulnerabilidades.edit',$vulnerabilidad->id) }}" data-toggle="tooltip" data-placement="top" title="Editar"><span class="fa fa-edit"></span></a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <div class="pull-right">
        {!! $links !!}
    </div>
@endsection