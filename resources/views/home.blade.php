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
@endsection