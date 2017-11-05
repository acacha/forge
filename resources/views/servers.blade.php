@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Your Laravel Forge Servers
@endsection

@section('contentheader_title')
    Your Laravel Forge Servers
@endsection

@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">

                <laravel-forge-servers></laravel-forge-servers>

            </div>
        </div>
    </div>
@endsection
