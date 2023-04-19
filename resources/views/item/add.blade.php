@extends('adminlte::page')

@section('title', '作品登録')

@section('content_header')
    <h1>作品登録</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-10">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card card-primary">
            <form method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">作品名</label>
                        <input type="text" class="form-control border border-secondary" id="name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="kana">作品名(よみがな)</label>
                        <input type="text" class="form-control border border-secondary" id="kana" name="kana">
                    </div>
                    <div class="form-group d-flex flex-column">
                        <label for="status">ステータス</label>
                        <select class="form-control  border-secondary" id="status" name="status">
                            <option value="" selected disabled></option>
                            @foreach(\App\Models\Item::STATUS as $key => $val)
                                <option value="{{ $key }}">
                                    {{ $val['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="type">ジャンル</label>
                        <select class="form-control  border-secondary" id="genre" name="genre">
                            <option value="" selected disabled></option>
                            @foreach($genres as $genre)
                                <option value="{{$genre->name}}">{{$genre->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="detail">あらすじ</label>
                        <textarea maxlength="500" name="detail" id="detail" class="form-control border border-secondary" rows="5"></textarea>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">登録</button>
                    <a href="/items" class="btn btn-outline-info" role="button">作品一覧に戻る </a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('css')
@stop

@section('js')
@stop
