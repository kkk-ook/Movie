@extends('adminlte::page')

@section('title', '作品一覧')

@section('content_header')
    <h1>作品一覧</h1>
@stop

@section('content')
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- Google font Icon -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>


    <div class="search-register">
        <form class="form-inline" action="{{ route('itemSearch') }}" method="get">
            <div class="form-group">
                <!-- セレクトボックス -->
                <select name="genre[]" class="form-control bg-light" aria-label="Default select example" multiple>
                    <option value="" selected>ジャンルを選択</option>
                    @foreach($genres as $genre)
                        <option value="{{$genre->name}}">{{$genre->name}}</option>
                    @endforeach
                </select>
                <!-- キーワード検索 -->
                <input type="text" name="keyword" class="form-control pr-5" placeholder="キーワードを入力">
                <input type="submit" value="検索" class="btn btn-primary">
                <!-- チェックボックス -->
                <div class="order">
                    <div class="order-icon">
                        <span class="material-icons" id="open">low_priority</span>
                    </div>
                    <div class="boxes">
                        <div id="boxes-1">
                            <input type="checkbox" id="box-1" name="orderKana[]">
                            <label for="box-1">あいう順</label>
                        </div>
                        <div id="boxes-2">
                            <input type="checkbox" id="box-2" name="orderReview[]">
                            <label for="box-2">レビューが高い順</label>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @can('admin-higher'){{-- 管理者に表示される --}}
        <div class="input-group-sm">
            <a href="{{ url('/add') }}" class="btn btn-secondary">作品登録</a>
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
                                <th>平均レビュー</th>
                                @can('admin-higher'){{-- 管理者に表示される --}}
                                    <th>更新日時</th>
                                @endcan
                                <th></th>
                                @can('admin-higher'){{-- 管理者に表示される --}}
                                    <th></th>
                                @endcan
                                @can('admin-higher'){{-- 管理者に表示される --}}
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
                                @can('admin-higher'){{-- 管理者に表示される --}}
                                    <td>{{ $item->created_at }}</td>
                                @endcan
                                <td>
                                    <a href="{{ route('detail', ['id'=>$item->id]) }}" class="detail">
                                        <span class="material-icons">description</span>
                                    </a>
                                </td>
                                @can('admin-higher'){{-- 管理者に表示される --}}
                                <td>
                                    <a href="{{ route('itemShow', ['id'=>$item->id]) }}" class="edit">
                                        <span class="material-icons">edit</span>
                                    </a>
                                </td>
                                <td>
                                    <span class="material-icons js-delete">delete_outline</span>
                                    <form action="{{ route('itemDelete',$item->id) }}" method="POST" class="edit-delete">
                                    @csrf
                                        <button type="submit" class="delete">
                                            <span class="material-icons">done</span>
                                        </button>
                                    </form>
                                    <span class="material-icons edit-cancel">clear</span>
                                </td>
                                @endcan
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
