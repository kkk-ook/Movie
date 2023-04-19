@extends('adminlte::page')

@section('title', '作品詳細')

@section('content_header')
    <h1>作品詳細</h1>
@stop

@section('content')
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Google font Icon -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                    <thead>
                            <tr>
                                @can('admin-higher'){{-- 管理者に表示される --}}
                                <th>ID</th>
                                @endcan
                                <th>作品名</th>
                                @can('admin-higher'){{-- 管理者に表示される --}}
                                <th>ステータス</th>
                                @endcan
                                <th>ジャンル</th>
                                <th>平均レビュー</th>
                                <th>更新日時</th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    @can('admin-higher'){{-- 管理者に表示される --}}
                                    <td>{{ $item->id }}</td>
                                    @endcan
                                    <td>{{ $item->name }}</td>
                                    @can('admin-higher'){{-- 管理者に表示される --}}
                                    <td><span class="p-1 text-white  {{ $item->status_class }}">{{$item->status_label}}</span></td>
                                    @endcan
                                    <td>
                                        @if($item->genres)
                                            @foreach($item->genres as $genre )
                                                {{$genre->name}}
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->reviews->isNotEmpty())
                                            <span class="material-icons review-stars">star</span>
                                            {{ $item->reviews->avg('stars') }}
                                        @endif
                                    </td>
                                    <td>{{ $item->created_at->format('Y.m.d') }}</td>
                                </tr>
                        </tbody>
                    </table>
                </div>
                <div class="detail p-4">
                    <h3>あらすじ：</h3>
                    <p>{!! nl2br(e($item->detail)) !!}</p>
                </div>
            </div>
            <div>
                <a href="/items" class="btn btn-outline-info" role="button">作品一覧戻る </a>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop