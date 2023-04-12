@extends('adminlte::page')

@section('title', 'ユーザー管理')

@section('content_header')
    <h1>ユーザー管理</h1>
@stop

@section('content')
    <form class="form-inline" action="{{ route('userSearch') }}" method="get">
        <div class="form-group d-flex mb-3">
            <input type="text" name="keyword"  class="form-control" placeholder="キーワードを入力">
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
                                <th>ID</th>
                                <th>名前</th>
                                <th>メールアドレス</th>
                                <th>登録日時</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td><a href="{{ route('userShow', $user->id) }}" class="btn btn-primary">編集</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="m-auto">
            {{ $users->links() }}
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
