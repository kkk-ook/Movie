@extends('adminlte::page')

@section('title', '作品一覧')

@section('content_header')
    <h1>作品一覧</h1>
@stop

@section('content')
    <form class="form-inline" action="{{ route('itemSearch') }}" method="get">
        <div class="form-group d-flex mb-3">
            <select name="type" class="form-control bg-light" aria-label="Default select example">
                <option value="" selected>ジャンルを選択</option>
                @foreach(\App\Models\Item::TYPE as $key => $val)
                <option value="{{$key}}">{{ $val['label'] }}</option>
                @endforeach
            </select>

            <input type="text" name="itemKeyword"  class="form-control pr-5" placeholder="キーワードを入力">
            <input type="submit" value="検索" class="btn btn-primary">
        </div>
    </form>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>作品名</th>
                                <th>ジャンル</th>
                                <th>レビュー</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->getTypeLabelAttribute() }}</td>
                                    <td></td>
                                    <td><a href="{{ route('detail', ['id'=>$item->id]) }}" class="btn btn-outline-secondary">詳細</a></td>
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
