@extends('adminlte::page')

@section('content')
    <div class="col-lg-12">
        <div class="col-lg-6">
            <h3>Editar</h3>
        </div>
        <div class="pull-right">
            <a class="btn btn-sm btn-default" href="{{ route('vulnsinfra.index') }}"><span class="fa fa-chevron-circle-left" aria-hidden="true"></span> Volver</a>
        </div>
    </div>


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


    <form class="form-horizontal" action="{{ route('vulnsinfra.update',$vulninfra->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nombre" class="col-lg-2 col-lg-offset-1" control-label>Nombre</label>
            <div class="col-lg-7">
                <input type="text" id="nombre" name="nombre" class="form-control" value="{{ $vulninfra->nombre }}"placeholder="Nombre">
            </div>
        </div>
        <div class="form-group">
            <label for="criticidad" class="col-lg-2 col-lg-offset-1" control-label">Criticidad</label>
            <div class="col-lg-2">
                <select name="criticidad_id" id="criticidad">
                    @foreach ($criticidades as $criticidad)
                        <option value="{{ $criticidad->id }}"
                        @if ($criticidad->id == $vulninfra->criticidad_id)
                            selected
                        @endif
                        >{{$criticidad->texto}}</option>
                    @endforeach
                </select>
            </div>
            <label for="exploit" class="col-lg-1" control-label>Exploit?</label>
            <div class="col-lg-2">
                <select name="exploit" id="exploit">
                    <option value="1" {{ $vulninfra->exploit === '1' ? 'selected' : '' }}>Si</option>
                    <option value="0" {{ $vulninfra->exploit === '0' ? 'selected' : '' }}>No</option>
                 </select>
            </div>
            <label for="protocolo" class="col-lg-1" control-label>Protocolo</label>
            <div class="col-lg-1">
                <select name="protocolo" id="protocolo">
                    <option value="TCP" {{ $vulninfra->protocolo === 'TCP' ? 'selected' : '' }}>TCP</option>
                    <option value="UDP" {{ $vulninfra->protocolo === 'UDP' ? 'selected' : '' }}>UDP</option>
                 </select>
            </div>
        </div>
        <div class="form-group">
            <label for="cve" class="col-lg-2 col-lg-offset-1" control-label>CVE</label>
            <div class="col-lg-2">
                <input type="text" id="cve" name="cve" class="form-control" value="{{ $vulninfra->cve }}" placeholder="CVE">
            </div> 
            <label for="salida_parche" class="col-lg-2 col-lg-offset-1" control-label>Salida Parche</label>
            <div class="col-lg-2">
                <input type="date" id="salida_parche" name="salida_parche" class="form-control" value="{{ $vulninfra->salida_parche }}" placeholder="Fecha Salida Parche">
            </div>             
        </div>
        <div class="form-group">
            <label for="resumen" class="col-lg-2 col-lg-offset-1" control-label>Resumen</label>
            <div class="col-lg-7">
                <textarea class="form-control" name="resumen" id="resumen" placeholder="Resumen">{{ $vulninfra->resumen }}</textarea>
            </div>
        </div>                 
        <div class="form-group">
            <label for="descripcion" class="col-lg-2 col-lg-offset-1" control-label>Descripcion</label>
            <div class="col-lg-7">
                <textarea class="form-control" style="height:100px" name="descripcion" id="descripcion" placeholder="Descripcion">{{ $vulninfra->descripcion }}</textarea>
            </div>
        </div>            
        <div class="form-group">
            <label for="solucion" class="col-lg-2 col-lg-offset-1" control-label>Solucion</label>
            <div class="col-lg-7">
                <textarea class="form-control" style="height:150px" name="solucion" id="solucion" placeholder="Solucion">{{ $vulninfra->solucion }}</textarea>
            </div>
        </div>            
        <div class="form-group">
            <label for="referencias" class="col-lg-2 col-lg-offset-1" control-label>Referencias</label>
            <div class="col-lg-7">
                <textarea class="form-control" style="height:80px" name="referencias" id="referencias" placeholder="Referencias">{{ $vulninfra->referencias }}</textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-sm btn-success"><span class="fa fa-plus" aria-hidden="true"></span>Editar</button>
            </div>
        </div>
    </form>

@endsection