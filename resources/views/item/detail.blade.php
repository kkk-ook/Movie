@extends('adminlte::page')

@section('title', '作品詳細')

@section('content_header')
    <h1>作品詳細</h1>
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
                                @can('admin-higher'){{-- 管理者に表示される --}}
                                <th>ステータス</th>
                                @endcan
                                <th>種別</th>
                                <th>更新日時</th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    @can('admin-higher'){{-- 管理者に表示される --}}
                                    <td><span class="p-1 text-white  {{ $item->status_class }}">{{$item->status_label}}</span></td>
                                    @endcan
                                    <td>{{$item->type_label}}</td>
                                    <td>{{ $item->created_at }}</td>
                                </tr>
                        </tbody>
                    </table>
                </div>
                <div class="detail p-4">
                    <h3>作品について：</h3>
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