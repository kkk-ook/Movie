@extends('adminlte::page')

@section('title', '商品一覧')

@section('content_header')
    <h1>商品一覧</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">商品一覧</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="input-group-append">
                                <a href="{{ url('items/add') }}" class="btn btn-default">商品登録</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>名前</th>
                                <th>種別</th>
                                <th>レビュー</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->type }}</td>
                                    <td></td>
                                </tr>
                        </tbody>
                    </table>
                </div>
                <h2>商品について：</h2>
                    <p>{!! nl2br(e($item->detail)) !!}</p>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop