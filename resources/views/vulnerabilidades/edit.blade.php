@extends('adminlte::page')

@section('content_header')
    <div class="col-lg-12 margin-tb panel panel-heading">
        <div class="pull-left">
           <h4>Editar {{ $vulnerabilidad->nombre }}</h4>
        </div>
        <div class="pull-right">
            <a class="btn btn-sm btn-default" href="javascript:history.back()"><span class="fa fa-chevron-circle-left" aria-hidden="true"></span> Volver</a>
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

    <form class="form-horizontal" action="{{ route('vulnerabilidades.update',$vulnerabilidad->id) }}" method="POST">
        @csrf
        @method('PUT')
    <input type="hidden" name="plugin" value="{{ $vulnerabilidad->plugin }}">
        <div class="form-group">
            <label for="nombre" class="col-lg-2 col-lg-offset-1" control-label>Nombre</label>
            <div class="col-lg-7">
                <input type="text" id="nombre" name="nombre" class="form-control" value="{{ $vulnerabilidad->nombre }}"placeholder="Nombre">
            </div>
        </div>
        <div class="form-group">
            <label for="criticidad" class="col-lg-2 col-lg-offset-1" control-label">Criticidad</label>
            <div class="col-lg-2">
                <select name="criticidad_id" id="criticidad">
                    @foreach ($criticidades as $criticidad)
                        <option value="{{ $criticidad->id }}"
                        @if ($criticidad->id == $vulnerabilidad->criticidad_id)
                            selected
                        @endif
                        >{{$criticidad->texto}}</option>
                    @endforeach
                </select>
            </div>
            <label for="exploit" class="col-lg-1" control-label>Exploit?</label>
            <div class="col-lg-2">
                <select name="exploit" id="exploit">
            <option></option>
                    <option value="1" {{ $vulnerabilidad->exploit === '1' ? 'selected' : '' }}>Si</option>
                    <option value="0" {{ $vulnerabilidad->exploit === '0' ? 'selected' : '' }}>No</option>
                 </select>
            </div>
            <label for="protocolo" class="col-lg-1" control-label>Protocolo</label>
            <div class="col-lg-1">
                <select name="protocolo" id="protocolo">
            <option></option>
                    <option value="TCP" {{ $vulnerabilidad->protocolo === 'TCP' ? 'selected' : '' }}>TCP</option>
                    <option value="UDP" {{ $vulnerabilidad->protocolo === 'UDP' ? 'selected' : '' }}>UDP</option>
                 </select>
            </div>
        </div>
        <div class="form-group">
            <label for="salida_parche" class="col-lg-2 col-lg-offset-1" control-label>Salida Parche</label>
            <div class="col-lg-2">
                @if($vulnerabilidad->salida_parche)
                    <input type="date" id="salida_parche" name="salida_parche" class="form-control" value="{{ $vulnerabilidad->salida_parche->format('Y-m-d') }}" placeholder="Fecha Salida Parche">
                @else
                    <input type="date" id="salida_parche" name="salida_parche" class="form-control" value="">
                @endif
            </div>             
        </div>
        <div class="form-group">
            <label for="resumen" class="col-lg-2 col-lg-offset-1" control-label>Resumen</label>
            <div class="col-lg-7">
                <textarea class="form-control" name="resumen" id="resumen" placeholder="Resumen">{{ $vulnerabilidad->resumen }}</textarea>
            </div>
        </div>                 
        <div class="form-group">
            <label for="descripcion" class="col-lg-2 col-lg-offset-1" control-label>Descripcion</label>
            <div class="col-lg-7">
                <textarea class="form-control" style="height:100px" name="descripcion" id="descripcion" placeholder="Descripcion">{{ $vulnerabilidad->descripcion }}</textarea>
            </div>
        </div>            
        <div class="form-group">
            <label for="solucion" class="col-lg-2 col-lg-offset-1" control-label>Solucion</label>
            <div class="col-lg-7">
                <textarea class="form-control" style="height:150px" name="solucion" id="solucion" placeholder="Solucion">{{ $vulnerabilidad->solucion }}</textarea>
            </div>
        </div>            
        <div class="form-group">
            <label for="cve" class="col-lg-2 col-lg-offset-1" control-label>CVE</label>
            <div class="col-lg-7">
                <textarea class="form-control" name="cve" id="cve" placeholder="CVE">{{ $vulnerabilidad->cve }}</textarea>
            </div> 
        </div>
        <div class="form-group">
            <label for="referencias" class="col-lg-2 col-lg-offset-1" control-label>Referencias</label>
            <div class="col-lg-7">
                <textarea class="form-control" style="height:80px" name="referencias" id="referencias" placeholder="Referencias">{{ $vulnerabilidad->referencias }}</textarea>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="col-lg-1 col-lg-offset-11 btn btn-sm btn-success"><span class="fa fa-plus" aria-hidden="true"></span> Guardar</button>
        </div>
    </form>

@endsection
