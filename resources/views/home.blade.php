@extends('adminlte::page')

@section('title', 'ホーム')

@section('content_header')
    <h1>タイムライン</h1>
@stop

@section('content')
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- Google font Icon -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    
@foreach  ($items as $item)
    @foreach( $item->reviews as $user)
    <div class="post w-75 mx-auto bg-white text-dark shadow-sm p-3 mb-5 bg-body rounded">
        <div class="d-flex border-bottom pb-3 mb-3">
            <h5></h5>
            <div class="ml-5">
                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modal{{$item->id}}">
                    <span class="material-icons">remove_red_eye</span>
                </button>
                <a href="{{ route('detail', ['id'=>$item->id]) }}" class="btn btn-outline-secondary">
                    <span class="material-icons">description</span>
                </a>
            </div>
        </div>
        <h5>{{ $item->name }}</h5>
        <p>{{ $user->stars }}</p>
        <p>{{ $user->comment }}</p>
    </div>

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
                <input type="range" class="w-75 js-range" name="stars" step="0.1" min="0.1" max="5"  value="{{ old('stars', $item->r_stars) }}">
                <span class="h4" id="value">{{ $item->stars }}</span>
            </div>
            @if ($errors->has('stars'))
                <p>{{$errors->first('stars')}}</p>
            @endif    
            <div class="text mt-3">
                <h6>スコア</h6>
                <textarea  maxlength="500" name="comment" id="comment" class="form-control border border-secondary" rows="5" placeholder="空欄でレビューすることも可能">{{ old('comment', $item->comment) }}</textarea>
            </div>
            @if ($errors->has('comment'))
                <p>{{$errors->first('comment')}}</p>
            @endif    
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                <button type="submit" class="btn btn-primary">投稿</button>
            </div>
        </div>
    </form>
    </div>
</div>

        @endforeach
@endforeach
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop

