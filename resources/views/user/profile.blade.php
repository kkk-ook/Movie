@extends('adminlte::page')

@section('title', 'プロフィール編集')

@section('content_header')
    <h1>プロフィール編集</h1>
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
<form action="{{ route('profileEdit')}}" method="post">
    @csrf
<!-- ログイン中の管理者かつ自分のID情報を表示する場合 または利用者が自分のID情報を表示する場合-->

    <input type="hidden" value="1">
        <dl>
            <div>
                <dt>名前</dt>
                <dd>
                    <input class="form-control" type="text" id="name" name="name" value="{{$user->name}}">
                </dd>
            </div>
            <div>
                <dt>メールアドレス</dt>
                <dd>
                    <input class="form-control" type="text" id="email" name="email" value="{{$user->email}}">
                </dd>
            </div>
            <div>
                <dt>パスワード<small>※8文字以上</small></dt>
                <dd>
                    <input class="form-control" type="password" id="password" name="password">
                </dd>
            </div>
            <div>
                <dt>パスワード確認</dt>
                <dd>
                    <input class="form-control" type="password"  id="confirm_password"  name="confirm_password" >
                </dd>
                <input type="hidden" name="role" value="{{$user->role}}">
            </div>
        </dl>


        <div class="form-group">
            <input class="form-control" type="hidden" name="id" value="{{$user->id}}">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">編集する</button>
        </div>

        <div class="form-group">
            <a href="/userDelete/{{$user->id}}"> 
                <button type="submit" class="btn btn-danger">削除する</button>
            </a>
        </div>

        <a href="/users" class="btn btn-outline-info" role="button">ユーザー管理に戻る </a>
        
        </form>
    </div>   

    </div>


@stop

@section('css')
@stop

@section('js')
@stop