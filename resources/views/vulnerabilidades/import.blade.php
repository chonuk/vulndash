@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="pull-left">
                <h2> Importar Vulnerabilidades</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-sm btn-default" href="{{ URL::previous() }}"><span class="fa fa-chevron-circle-left" aria-hidden="true"></span> Volver</a>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="col-lg-4">
		<div class="well col-lg-12">
                <strong>Nessus Security Center<br>CSV - columnas: </strong>
                <ul>
                	<li>Plugin</li>
                        <li>Plugin Name</li>
                        <li>Severity</li>
                        <li>Ip Address</li>
                        <li>Protocol</li>
                        <li>Port</li>
                        <li>Exploit</li>
                        <li>DNS Name</li>
                        <li>NetBIOS Name</li>
                        <li>Synopsis</li>
                        <li>Description</li>
                        <li>Solution</li>
                        <li>See Also</li>
                        <li>CVE</li>
                        <li>First Discovered</li>
                        <li>Last Observed</li>
                        <li>Patch Publication Date</li>
                </ul>
		</div>
            </div>            
	    <div class="col-lg-4">
		<div class="well col-lg-12">
		<strong>Faast<br>CSV - columnas: </strong>
                <ul>
			<li>A definir</li>
		</ul>
		</div>
	    </div>
	    <div class="col-lg-4">
		<div class="well col-lg-12">
	    		<strong>Serpico<br>Json exportado sin modificar</strong>
		</div><br>
		<div class="well col-lg-12">
            		<form action="{{ route('vulnerabilidades.importar') }}" method="POST" enctype="multipart/form-data">
                		{{ csrf_field() }}
                		<div class="form col-lg-12">
                    			<label class="col-lg-4" control-label>Tipo</label>
                    			<select class="col-lg-4" name="tipo" id="tipo">
	                	        	<option value="nessus">Nessus</option>
						<option value="faast">Faast</option>
        	   		             	<option value="serpico">Serpico</option>
                	  		</select>
                		</div>
				<div class="col-lg-12">
					<input type="file" class="form col-lg-12" name="fileToUpload" id="fileToUpload" required>
				</div>
                		<div class="col-lg-12">
                    			<button class="btn btn-primary col-lg-4" type="submit"><span class="fa fa-plus" aria-hidden="true"></span> Importar</button>
                		</div>
            		</form>
        	</div>
    	    </div>
	</div>
@endsection
