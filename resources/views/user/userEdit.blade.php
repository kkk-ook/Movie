@extends('adminlte::page')

@section('title', 'ユーザー編集')

@section('content_header')
    <h1>ユーザー編集</h1>
@stop

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ route('userEdit',$user->id)}}" method="post">
    @csrf
<!-- ログイン中の管理者かつ自分のID情報を表示する場合 または利用者が自分のID情報を表示する場合-->
@if((Auth::user()->role == 1 && $user->id == Auth::id()) || Auth::user()->role == 0)
    <input type="hidden" value="1">
        <dl>
            <div>
                <dt>名前</dt>
                <dd>
                    <input class="form-control" type="text" name="name" value="{{$user->name}}">
                </dd>
            </div>
            <div>
                <dt>メールアドレス</dt>
                <dd>
                    <input class="form-control" type="text" name="email" value="{{$user->email}}">
                </dd>
            </div>
            <div>
                <dt>パスワード<small>※8文字以上、必須入力</small></dt>
                <dd>
                    <input class="form-control" type="password" name="password">
                </dd>
            </div>
            <div>
                <dt>パスワード確認</dt>
                <dd>
                    <input class="form-control" type="password" name="confirm_password" >
                </dd>
                <input type="hidden" name="role" value= "{{$user->role}}">
            </div>
        </dl>



<!-- 管理者が利用者のID画面を編集する場合 -->
@else
    <input type="hidden" value="2" name = "type">
    <dl>
        <dt>名前</dt>
        <dd>{{$user->name}}</dd>
        <input type="hidden" value="{{$user->name}}" name = "name">
        <dt>メールアドレス</dt>
        <dd>{{$user->email}}</dd>
        <input type="hidden" value="{{$user->email}}" name = "email">
@endif
        <div class="form-group">
            <input class="form-control" type="hidden" name="id" value="{{$user->id}}">
        </div>

        <dt>アクセス権限</dt>
        <dd>
            <input type="radio" name="role" value= "1" {{ $user->role == "1" ? "checked" : "" }}>管理者
        </dd>
        <dd>
            <input type="radio" name="role" value= "0" {{ $user->role == "0" ? "checked" : "" }}>ユーザー
        </dd>
    </dl>

        
    <div class="form-group">
        <button type="submit" class="btn btn-primary">編集する</button>
    </div>
</form>

<form action="{{ route('userDelete',$user->id) }}" method="POST">
@csrf
    <div class="form-group">
        <button type="submit" class="btn btn-danger">削除する</button>
    </div>
</form>

    <a href="/users" class="btn btn-outline-info" role="button">ユーザー管理に戻る </a>

    </div>   

    </div>


@stop

@section('css')
@stop

@section('js')
@stop