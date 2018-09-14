@extends('adminlte::page')

@section('searchbar')
<form action="{{ route('ocurrencias.index') }}" class="form-inline" method="GET" role="search">
    <div class="form-group">
        <div class="input-group input-group-sm">
            <input type="text" class="form-control" name="q" placeholder="Ip,Host,Vulnerabilidad,Plataforma " value="{{ $q }}">
            <span class="input-group-btn">
                <button type="submit" class="btn btn-default">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>
    </div>
</form>
@endsection

@section('content')
    <table id="ocurrencias-table" class="table table-condensed table-striped table-bordered">
        <thead>
        <tr>
            <th width="50%">@sortablelink('vulnerabilidad_nombre','Nombre')</th>
            <th>@sortablelink('criticidad_id','Criticidad')</th>
            <th>@sortablelink('plataforma_nombre','Plataforma')</th>
            <th>@sortablelink('activo_ip','Ip')</th>
            <th>@sortablelink('activo_hostname','Hostname')</th>
            <th>@sortablelink('estado_texto','Estado')</th>
            <th width="100px">Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($ocurrencias as $ocurrencia)
        <tr>
            <td>{{ $ocurrencia->vulnerabilidad_nombre }}</td>
            <td><span class="label label-{{ $ocurrencia->criticidad_color }}" >{{ $ocurrencia->criticidad_texto }}</span></td>
            <td>{{ $ocurrencia->plataforma_nombre }}</td>
            <td>{{ $ocurrencia->activo_ip }}</td>
            <td>{{ $ocurrencia->activo_hostname }}</td>
            <td><span class="label label-{{ $ocurrencia->estado_color }}" >{{ $ocurrencia->estado_texto }}</span></td>
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
    <div class="row"></div>
@endsection