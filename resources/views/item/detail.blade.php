@extends('adminlte::page')

@section('title', '商品詳細')

@section('content_header')
    <h1>商品詳細</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                    <thead>
                            <tr>
                                <th>ID</th>
                                <th>名前</th>
                                <th>ステータス</th>
                                <th>種別</th>
                                <th>更新日時</th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td><span class="p-1 text-white  {{ $item->status_class }}">{{$item->status_label}}</span></td>
                                    <td>{{$item->type_label}}</td>
                                    <td>{{ $item->created_at }}</td>
                                </tr>
                        </tbody>
                    </table>
                </div>
                <div class="detail p-4">
                    <h3>商品について：</h3>
                    <p>{!! nl2br(e($item->detail)) !!}</p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop