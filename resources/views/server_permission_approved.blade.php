@extends('adminlte::layouts.errors')

@section('htmlheader_title')
    Server permission approved
@endsection

@section('main-content')

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Server approved!</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <h4><i class="fa fa-warning text-yellow"></i>You have been approved access to server:</h4>
            <ul>
                <li>Name: {{ $server->name }}</li>
                <li>User: {{ $server->user }}</li>
                <li>Forge id: {{ $server->forge_id }}</li>
            </ul>
            Go to <a href="{{ config('forge.url') }}/home">Acacha Forge</a>
        </div>
        <!-- /.box-body -->
    </div>
@endsection