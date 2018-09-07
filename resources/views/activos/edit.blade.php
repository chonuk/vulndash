@extends('adminlte::page')

@section('content_header')
    <div class="col-lg-12 margin-tb panel panel-heading">
        <div class="pull-left">
            <h4>Editar Activo</h4>
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


    <form class="form-horizontal" action="{{ route('activos.update',$activo->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="ip" class="col-lg-2 col-lg-offset-1" control-label">Ip</label>
            <div class="col-lg-7">
                <input type="text" id="ip" name="ip" class="form-control" value="{{ $activo->ip }}"placeholder="Ip">
            </div>
        </div>
        <div class="form-group">
            <label for="hostname" class="col-lg-2 col-lg-offset-1" control-label">Hostname</label>
            <div class="col-lg-7">
                <input type="text" id="hostname" name="hostname" class="form-control" value="{{ $activo->hostname }}"placeholder="Hostname">
            </div>
        </div>
        <div class="form-group">
            <label for="os" class="col-lg-2 col-lg-offset-1" control-label">Sistema Operativo</label>
            <div class="col-lg-7">
                 <input type="text" id="os" name="os" class="form-control" value="{{ $activo->os }}"placeholder="Sistema Operativo">
            </div>
        </div>            
        <div class="form-group">
            <label for="plataformas" class="col-lg-2 col-lg-offset-1" control-label">Plataformas<br></label>Haga click para agregar
            <div class="col-lg-3">
                {!! Form::select('plataformas1[]', $plataformas, null, ['id' => 'plataformas1','class' => 'form-control', 'multiple','size' => '10']) !!}
            </div>
            <div class="col-lg-1"><br><br><br><center>
                <span class="badge"><<</span><br><br>
                <span class="badge">>></span><br>
            </center>
            </div>
            <div class="col-lg-3">
                {!! Form::select('plataformas[]', $activo->plataformas->pluck('nombre','id')->all(),null, ['id' => 'plataformas','class' => 'form-control', 'multiple','size' => '10']) !!}
            </div>
        </div>      
        <div class="form-group col-lg-1 pull-right">
            <button id="btnGrabar" type="submit" class="pull-right btn btn-sm btn-success"><span class="fa fa-plus" aria-hidden="true"></span> Grabar</button>
        </div>
    </form>

@endsection
@section('js')
<script type="text/javascript">
$(document).ready(function(){
    $('#plataformas1').on('click', function(e){
        if (!$("#plataformas option[value='" +$(this).val()+ "']").length){
            if(e.target.text){
                $('#plataformas').append('<option value="'+ e.target.value + '">'+ e.target.text + '</option>');
 
            }
        }
    });

    $('#plataformas').on('click', function(e){
        $('#plataformas option:selected').remove();
    });
});
$('#btnGrabar').click(function(){
    var selObj = document.getElementById('plataformas');
    if(selObj.options.length!=0) {
        for (var i=0; i<selObj.options.length; i++) {
            selObj.options[i].selected = true;
        } 
    }
});
</script>
@endsection