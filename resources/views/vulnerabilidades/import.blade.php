@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="pull-left">
                <h2> Importar Vulnerabilidades</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-sm btn-default" href="{{ route('vulnerabilidades.index') }}"><span class="fa fa-chevron-circle-left" aria-hidden="true"></span> Volver</a>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="col-lg-4">
        		<div class="well col-lg-12">
                    <strong>Nessus Security Center<br>Archivo csv - columnas: </strong>
                    <ul>
                    	<li><strong>Plugin *</strong></li>
                        <li><strong>Plugin Name *</strong></li>
                        <li><strong>Severity *</strong></li>
                        <li>Ip Address</li>
                        <li>Protocol</li>
                        <li>Port</li>
                        <li>Exploit</li>
                        <li>DNS Name</li>
                        <li>NetBIOS Name</li>
                        <li>Synopsis</li>
                        <li><strong>Description *</strong></li>
                        <li>Solution</li>
                        <li>See Also</li>
                        <li>CVE</li>
                        <li>First Discovered</li>
                        <li>Last Observed</li>
                        <li>Patch Publication Date</li>
                    </ul>
                    <strong>* Requeridos</strong>
        		</div>
            </div>            
    	    <div class="col-lg-4">
                <div class="well col-lg-12">
                    <strong>Serpico<br>Archivo json exportado sin modificar</strong>
                </div>                
                <div class="well col-lg-12">
                    <span class="label label-danger">Cooming Soon</span><br>
                    <strong>Faast<br>Archivo csv - columnas: </strong>
                    <ul>
                        <li>A definir...</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif                
                <div class="well col-lg-12">
                    <form class="form-horizontal" action="{{ route('vulnerabilidades.importar') }}" method="POST" enctype="multipart/form-data">
                		{{ csrf_field() }}
                		<div class="form-group">
        		          	<label for="tipo" class="col-lg-2 control-label">Tipo</label>
                            <div class="col-lg-10">
                    			<select class="form-control" name="tipo" id="tipo">
                    	        	<option value="nessus">Nessus</option>
    				        		<option value="faast">Faast</option>
                                    <option value="serpico">Serpico</option>
                                </select>
                            </div>
                        </div>
				        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <input type="file" class="" name="fileToUpload" id="fileToUpload" required>
                            </div>
				        </div>
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <button class="btn btn-sm btn-primary" type="submit"><span class="fa fa-plus" aria-hidden="true"></span> Importar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
