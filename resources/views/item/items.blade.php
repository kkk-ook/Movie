@extends('adminlte::page')

@section('title', '作品一覧')

@section('content_header')
    <h1>作品一覧</h1>
@stop

@section('content')
    <div class="d-flex justify-content-between">
        <form class="form-inline" action="{{ route('search') }}" method="get">
            <div class="form-group d-flex mb-3">
                <select name="type" class="form-control bg-light" aria-label="Default select example">
                    <option value="" selected>ジャンルを選択</option>
                    @foreach(\App\Models\Item::TYPE as $key => $val)
                    <option value="{{$key}}">{{ $val['label'] }}</option>
                    @endforeach
                </select>
                <input type="text" name="keyword" class="form-control pr-5" placeholder="キーワードを入力">
                <input type="submit" value="検索" class="btn btn-primary">
            </div>
        </form>
        @can('admin-higher'){{-- 管理者に表示される --}}
        <div class="input-group-sm">
            <a href="{{ url('/add') }}" class="btn btn-secondary">商品登録</a>
        </div>
        @endcan
    </div>

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
                                @can('admin-higher'){{-- 管理者に表示される --}}
                                <th>更新日時</th>
                                @endcan
                                <th></th>
                                @can('admin-higher'){{-- 管理者に表示される --}}
                                <th></th>
                                <th></th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    @can('admin-higher'){{-- 管理者に表示される --}}
                                    <td>{{ $item->id }}</td>
                                    @endcan
                                    <td>{{ $item->name }}</td>
                                    @can('admin-higher'){{-- 管理者に表示される --}}
                                    <td><span class="p-1 text-white  {{ $item->status_class }}">{{$item->status_label}}</span></td>
                                    @endcan
                                    <td>{{$item->getTypeLabelAttribute()}}</td>
                                    @can('admin-higher'){{-- 管理者に表示される --}}
                                    <td>{{ $item->created_at }}</td>
                                    @endcan
                                    <td><a href="{{ route('detail', ['id'=>$item->id]) }}" class="btn btn-outline-secondary">詳細</a></td>
                                    @can('admin-higher'){{-- 管理者に表示される --}}
                                    <td><a href="{{ route('itemShow', $item->id) }}" class="btn btn-primary">編集</a></td>
                                    <td>
                                        <form action="{{ route('itemDelete',$item->id) }}" method="POST">
                                        @csrf
                                            <button type="submit" class="btn btn-danger">削除</button>
                                        </form>
                                    </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="m-auto">
            {{ $items->links() }}
        </div>
    </div>

@stop

@section('css')
@stop

@section('js')
@stop
