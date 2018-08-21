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
    <table id="ocurrencias-table" class="table table-condensed table-striped table-bordered">
        <thead>
        <tr>
            <th width="30%">@sortablelink('vulnerabilidades.nombre','Nombre')</th>
            <th>@sortablelink('vulnerabilidades.criticidad_id','Criticidad')</th>
            <th>@sortablelink('activos_count','Activos')</th>
            <th>@sortablelink('vulnerabilidades.exploit')</th>
            <th>@sortablelink('primer_deteccion','Primer Deteccion')</th>
            <th>@sortablelink('estados.texto','Estado')</th>
            <th width="100px">Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($ocurrencias as $ocurrencia)
        <tr>
            <td>{{ $ocurrencia->vulnerabilidades->nombre }}</td>
            <td><span class="label label-{{ $ocurrencia->vulnerabilidades->criticidad->color }}" >{{ $ocurrencia->vulnerabilidades->criticidad->texto }}</span></td>
            <td>{{ $ocurrencia->activos_count }}</td>
            <td>{{ $ocurrencia->vulnerabilidades->exploit ? 'Si' : '-' }}</td>
            <td>{{ $ocurrencia->primer_deteccion->format('d/m/Y H:i') }} </td>
            <td><span class="label label-{{ $ocurrencia->estados->color }}" >{{ $ocurrencia->estados->texto }}</span></td>
            <td>
                <a class="btn btn-sm btn-info" href="{{ route('ocurrencias.show',$ocurrencia->id) }}" data-toggle="tooltip" data-placement="top" title="Ver Detalle"><span class="fa fa-info-circle"></span></a>
                <a class="btn btn-sm btn-warning" href="{{ route('ocurrencias.edit',$ocurrencia->id) }}" data-toggle="tooltip" data-placement="top" title="Editar"><span class="fa fa-edit"></span></a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <div class="pull-right">
        {!! $links !!}
    </div>
@endsection