@extends('adminlte::page')

@section('title', '商品一覧')

@section('content_header')
    <h1>商品一覧</h1>
@stop

    <div style="width:700px; margin:100px auto; text-align:center;">
    <h4 class="name">ユーザー管理画面</h4>
    
    <div>
        <table class="table table-bordered" margin-top=10px;>


        <tr>
            <th style ="width:50px; ">ID</th>
            <th style ="width:150px;">名前</th>
            <th style ="width:250px;">メールアドレス</th>
            <th style ="width:150px;">ステータス</th>
            <th></th>
        
        </tr>

        </div>
        @foreach($users as $value)
        <tr>
            
            <td>{{$value->id}}</td>
            <td>{{$value->name}}</td>
            <td>{{$value->email}}</td>
            <td>@if($value->role == 1)管理者@endif</td>
            
            
            <td><a href="user/edit/{{$value->id}}"><button class="btn btn-info btn-block btn-sm">編集</button></a></td>
            
        </tr>
        @endforeach
        </div>
    </table>
    </div>
    <div style="text-align:center;">
    <a href="/home" class="btn btn-outline-info" role="button">ホームに戻る</a>
    </div>


</body>

<a class="pagetop" href="#">
    <div class="pagetop__arrow"></div></a>
    @section('css')
@stop

@section('js')
@stop