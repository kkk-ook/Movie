@extends('adminlte::page')

@section('title', '商品登録')

@section('content_header')
    <h1>商品登録</h1>
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
                            <label for="name">名前</label>
                            <input type="text" class="form-control border border-secondary" id="name" name="name">
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
                            <label for="type">種別</label>
                            <select class="form-control  border-secondary" id="type" name="type">
                                <option value="" selected disabled></option>
                                @foreach(\App\Models\Item::TYPE as $key => $val)
                                    <option value="{{ $key }}">
                                    {{ $val['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="detail">説明</label>
                            <textarea maxlength="500" name="detail" id="detail" class="form-control border border-secondary" rows="5"></textarea>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">登録</button>
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
