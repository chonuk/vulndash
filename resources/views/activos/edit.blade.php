@extends('adminlte::page')

@section('content_header')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Editar Activo</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-sm btn-default" href="javascript:history.back()"><span class="fa fa-chevron-circle-left" aria-hidden="true"></span> Volver</a>
            </div>
        </div>
    </div>

@endsection
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Error!</strong> Hubo un problema con los datos ingresados.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form class="form-horizontal" action="{{ route('activos.update',$activo->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="ip" class="col-lg-2 col-lg-offset-2" control-label">Ip</label>
            <div class="col-lg-6">
                <input type="text" id="ip" name="ip" class="form-control" value="{{ $activo->ip }}"placeholder="Ip">
            </div>
        </div>
        <div class="form-group">
            <label for="hostname" class="col-lg-2 col-lg-offset-2" control-label">Hostname</label>
            <div class="col-lg-6">
                <input type="text" id="hostname" name="hostname" class="form-control" value="{{ $activo->hostname }}"placeholder="Hostname">
            </div>
        </div>
        <div class="form-group">
            <label for="os" class="col-lg-2 col-lg-offset-2" control-label">Sistema Operativo</label>
            <div class="col-lg-6">
                 <input type="text" id="os" name="os" class="form-control" value="{{ $activo->os }}"placeholder="Sistema Operativo">
            </div>
        </div>            
        <div class="form-group">
            <label for="plataformas" class="col-lg-2 col-lg-offset-2" control-label">Plataforma</label>
            <div class="col-lg-6">
                {!! Form::select('plataformas[]', $plataformas, $activo->plataformas->pluck('id')->all(), ['class' => 'form-control', 'multiple']) !!}
                </div>
        </div>      
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-sm btn-success"><span class="fa fa-plus" aria-hidden="true"></span>Editar</button>
            </div>
        </div>
    </form>

@endsection