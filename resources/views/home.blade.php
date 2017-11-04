@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Ask server permission
@endsection

@section('contentheader_title')
 Ask for server permission
@endsection

@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">

                <ask-server-permission></ask-server-permission>

            </div>
        </div>
    </div>
@endsection
