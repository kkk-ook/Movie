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

    <div class="search-register">
        <form class="form-inline" action="{{ route('reviewSearch') }}" method="get">
            <div class="form-group">
                <!-- キーワード検索 -->
                <input type="text" name="keyword" class="form-control pr-5" placeholder="キーワードを入力">
                <input type="submit" value="検索" class="btn btn-primary">
                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <span class="material-icons">zoom_in</span>
                </button>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">詳細検索</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- キーワード検索 -->
                    <input type="text" name="keywordModal" class="form-control keywordModal" placeholder="キーワードを入力">
                    <!-- セレクトボックス -->
                    <div class="genre-order">
                        <div class="genre">
                            <h4>ジャンル</h4>
                            <select name="genre[]" class="form-control" aria-label="Default select example" size="10" multiple>
                                <option value="" selected>ジャンルを選択</option>
                                @foreach($genres as $genre)
                                    <option value="{{$genre->name}}">{{$genre->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- チェックボックス -->
                        <div class="order">
                            <h4>並び替え</h4>
                            <div class="boxes">
                                <div id="boxes-1">
                                    <input type="checkbox" id="box-1" name="orderKana[]">
                                    <label for="box-1">あいう順</label>
                                </div>
                                <div id="boxes-2">
                                    <input type="checkbox" id="box-2" name="orderReviewDesc[]">
                                    <label for="box-2">レビューが高い順</label>
                                </div>
                                <div id="boxes-3">
                                    <input type="checkbox" id="box-3" name="orderReviewAsc[]">
                                    <label for="box-3">レビューが低い順</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                    <input type="submit" value="検索" class="btn btn-primary">
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

<!-- 一覧 -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>作品名</th>
                                <th>ジャンル</th>
                                <th>平均レビュー</th>
                                <th>マイレビュー</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>
                                    @foreach($item->genres as $genre )
                                        {{$genre->name}}
                                    @endforeach
                                </td>
                                <td>
                                    @if($item->reviews->isNotEmpty())
                                    <span class="material-icons review-stars">star</span>
                                        {{ round($item->reviews->avg('stars'),1) }}
                                    @endif
                                    @foreach ($itemreviews as $itemreview)
                                        @if ($itemreview->item_id == $item->id)
                                            ({{ $itemreview->count_user }})
                                        @endif
                                    @endforeach
                                </td>
                                @php
                                    $myreview = $item->reviews->first(function ($value, $key) use ($user)  {return $value->user_id == $user->id;});
                                @endphp
                                <td>
                                @if($myreview)
                                    <span class="material-icons review-stars">star</span>
                                    {{ $myreview->stars }}
                                @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-outline-black buttonChange @if($myreview) changeColor @endif" data-bs-toggle="modal" data-bs-target="#modal{{$item->id}}">
                                        <span class="material-icons">remove_red_eye</span>
                                    </button>
                                </td>
                                <td>
                                    <div class="tool">
                                        <a href="{{ route('detail', ['id'=>$item->id]) }}" class="detail">
                                            <span class="material-icons">description</span>
                                        </a>
                                        <div class="description">詳細を見る</div>
                                    </div>
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
                                        <input type="hidden" name="user_id" value="{{$user->id}}">
                                        <div class="modal-body">
                                            <div class="title h4">{{ $item->name }}</div>
                                            <div class="score">
                                                <h6>スコア</h6>
                                                <input type="range" class="w-75 js-range" name="stars" step="0.1" min="0.1" max="5" value="2.5">
                                                <span class="h4" id="value">2.5</span>
                                            </div>
                                            <div class="text mt-3">
                                                <h6>コメント</h6>
                                                <textarea  maxlength="500" name="comment" id="comment" class="form-control border border-secondary" rows="5" placeholder="空欄でレビューすることも可能">{{ old('comment', $item->comment) }}</textarea>
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
