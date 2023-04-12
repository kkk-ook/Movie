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
    
@foreach ($reviews as $review)
    <div class="post">
        <div class="post-inner">
            <div class="post-head">
                <h2>{{ $review->user->name }} さんのレビュー</h2>
                <p>{{ $review->updated_at->format('Y/m/d') }}</p>
            </div>
            <div class="post-btn">
                <a href="{{ route('detail', ['id'=>$review->item->id]) }}" class="btn btn-outline-secondary">
                    <span class="material-icons">description</span>
                </a>
            </div>
        </div>
        <div class="post-body">
            <h2>{{ $review->item->name }}</h2>
            <div class="stars">
                <span class="material-icons">star</span>
                <p>{{ $review->stars }}</p>
            </div>
            <p>{!! nl2br(e($review->comment)) !!}</p>
        </div>
    </div>


@endforeach
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop

