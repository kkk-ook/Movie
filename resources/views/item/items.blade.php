@extends('adminlte::page')

@section('title', '商品管理')

@section('content_header')
    <h1>商品管理</h1>
@stop

@section('content')
    <div class="d-flex justify-content-between">
        <form class="form-inline" action="{{ route('itemSearch') }}" method="get">
            <div class="form-group d-flex mb-3">
                <select name="type" class="form-control bg-light" aria-label="Default select example">
                    <option value="" selected>ジャンルを選択</option>
                    @foreach(\App\Models\Item::TYPE as $key => $val)
                    <option value="{{$key}}">{{ $val['label'] }}</option>
                    @endforeach
                </select>
                <input type="text" name="itemKeyword" class="form-control pr-5" placeholder="キーワードを入力">
                <input type="submit" value="検索" class="btn btn-primary">
            </div>
        </form>
        <div class="input-group-sm">
            <a href="{{ url('/add') }}" class="btn btn-secondary">商品登録</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>作品名</th>
                                <th>ステータス</th>
                                <th>ジャンル</th>
                                <th>更新日時</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td><span class="p-1 text-white  {{ $item->status_class }}">{{$item->status_label}}</span></td>
                                    <td>{{$item->getTypeLabelAttribute()}}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td><a href="{{ route('detail', ['id'=>$item->id]) }}" class="btn btn-outline-secondary">詳細</a></td>
                                    <td><a href="{{ route('itemShow', $item->id) }}" class="btn btn-primary">編集</a></td>
                                    <td>
                                        <form action="{{ route('itemDelete',$item->id) }}" method="POST">
                                        @csrf
                                            <button type="submit" class="btn btn-danger">削除</button>
                                        </form>
                                    </td>
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
