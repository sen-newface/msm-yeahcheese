@extends('layouts.template')

@section('title', 'イベント作成')

@section('content')
<div class="container">
    <div class="jumbotron bg-white border">
        <h2>イベント作成</h2>
        <p class="text-secondary">イベント情報を入力してイベントを作成しましょう。イベントの写真はイベントを編集する際に登録することができます。</p>
    </div>

    <div class="row my-2">
        <div class="col-md-6 offset-md-3">
            <form method="POST" action="/events/">
                <div class="form-group">
                    @csrf
                    <label>イベント名</label>
                    <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                    @if($errors->has('title'))
                    <div class="alert alert-danger" role="alert">{{ $errors->first('title') }}</div>
                    @endif
                </div>

                <div class="form-group">
                    <label>公開開始日</label>
                    <input type="date" class="form-control" name="release_date" value="{{ old('release_date') }}">
                    @if($errors->has('release_date'))
                    <div class="alert alert-danger" role="alert">{{ $errors->first('release_date') }}</div>
                    @endif
                </div>

                <div class="form-group">
                <label>公開終了日</label>
                <input type="date" class="form-control" name="end_date" value="{{ old('end_date') }}">
                @if($errors->has('end_date'))
                <div class="alert alert-danger" role="alert">{{ $errors->first('end_date') }}</div>
                @endif
                </div>

                <button type="submit" class="col-sm-2 offset-sm-5 btn btn-primary">作成</button>
            </form>
        </div>
    </div>
</div>
@endsection
