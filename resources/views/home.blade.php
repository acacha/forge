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

                <div class="box box-primary">
                    <form method="post" @submit.prevent="submit" @keydown="clearErrors($event.target.name)">
                        <div class="box-header with-border">
                            <h3 class="box-title">Forge publish (CLI CLient)</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                    <i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                                    <i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="callout callout-warning">
                                <h4>Once you have and approved server use in your project install forge publish:</h4>

                                <p>composer require acacha/forge-publish</p>
                                <p>php artisan publish:init</p>
                                <p>php artisan publish</p>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
