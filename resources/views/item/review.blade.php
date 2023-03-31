@extends('adminlte::page')

@section('title', 'レビュー')

@section('content_header')
    <h1>レビュー</h1>
@stop

@section('content')
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- Google font Icon -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>

    <div class="d-flex justify-content-between">
        <form class="form-inline" action="{{ route('review') }}" method="get">
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
                                <th>作品名</th>
                                <th>ジャンル</th>
                                <th>レビュー</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{$item->getTypeLabelAttribute()}}</td>
                                    <td><!-- 平均レビュー数表示 --></td>
                                    <td>
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#modal{{$item->id}}">
                                            レビューする
                                        </button>
                                    </td>

                                    <!-- モーダル -->
                                    <div class="modal fade" id="modal{{$item->id}}" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabel">レビュー</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('review') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="item_id" value="{{$item->id}}">
                                            <div class="modal-body">
                                                <div class="title h4">{{$item->name}}</div>
                                                <div class="score">
                                                    <h6>スコア</h6>
                                                    <input type="range" class="w-75 js-range" name="stars" step="0.1" min="0.1" max="5">
                                                    <span class="h4" id="value">2.5</span>
                                                </div>
                                                <div class="text mt-3">
                                                    <h6>スコア</h6>
                                                    <textarea  maxlength="500" name="comment" id="comment" class="form-control border border-secondary" rows="5"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                                                    <button type="submit" class="btn btn-primary">投稿</button>
                                                </div>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                    <td>
                                        <a href="{{ route('detail', ['id'=>$item->id]) }}" class="btn btn-outline-secondary">
                                            詳細
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="pagination">
            {{ $items->links() }}
        </div>
    </div>

    <script src="{{ asset('/js/main.js') }}"></script>
@stop

@section('css')
@stop

@section('js')
@stop
