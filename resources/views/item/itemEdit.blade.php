@extends('adminlte::page')

@section('title', '商品編集')

@section('content_header')
    <h1>商品編集</h1>
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
<form action="{{ route('itemEdit',$item->id)}}" method="get">
    @csrf
<!-- ログイン中の管理者かつ自分のID情報を表示する場合 または利用者が自分のID情報を表示する場合-->
    <input type="hidden" value="1">
        <dl>
            <div>
                <dt>作品名</dt>
                <dd>
                    <input type="text" class="form-control border border-secondary" id="name" name="name" value="{{$item->name}}">
                </dd>
            </div>
            <div>
                <dt>作品名(よみがな)</dt>
                <dd>
                    <input type="text" class="form-control border border-secondary" id="kana" name="kana" value="{{$item->kana}}">
                </dd>
            </div>
            <div class="form-group d-flex flex-column">
                <dt for="status">ステータス</dt>
                <dd>
                    <select class="form-control  border-secondary" id="status" name="status">
                        <option value="" disabled></option>
                        @foreach(\App\Models\Item::STATUS as $key => $val)
                        <option value="{{ $key }}" {{ $key == old('status',$item->status) ? 'selected' : '' }}>
                                {{ $val['label'] }}
                            </option>
                        @endforeach
                    </select>
                </dd>
            </div>
            <div class="form-group">
                <dt for="type">ジャンル</dt>
                <dd>
                    <select class="form-control  border-secondary" id="type" name="type">
                        <option value="" disabled></option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre->name }}" {{ $genre == old('genre',$genre->name) ? 'selected' : '' }}>
                                {{ $genre->name }}
                            </option>
                        @endforeach
                    </select>
                </dd>
            </div>
            <div class="form-group">
                <dt>あらすじ</dt>
                <dd for="detail">
                    <textarea maxlength="500" name="detail" id="detail" class="form-control border border-secondary" rows="5">{{$item->detail}}</textarea>
                </dd>
                <input type="hidden" name="role" value="">
            </div>
        </dl>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">編集する</button>
    </div>
</form>

<form action="{{ route('itemDelete',$item->id) }}" method="POST">
@csrf
    <div class="form-group">
        <button type="submit" class="btn btn-danger">削除する</button>
    </div>
</form>

    <a href="/items" class="btn btn-outline-info" role="button">ユーザー管理に戻る </a>

    </div>   

    </div>


@stop

@section('css')
@stop

@section('js')
@stop