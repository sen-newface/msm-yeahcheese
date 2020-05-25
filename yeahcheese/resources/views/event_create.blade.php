@extends('layouts.template')

@section('title', 'イベント作成')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <h2 class="text-center my-2">イベント新規作成</h2>
        </div>
    </div>

    <div class="row my-2">
        <div class="col-md-4 offset-md-4">
            <form method="POST" action="/events/">
                <div class="form-group">
                    @csrf
                    <label>イベント名</label>
                    <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                </div>
                @if($errors->has('title'))
                <div class="alert alert-danger" role="alert">{{ $errors->first('title') }}</div>
                @endif

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
                @if($errors->any())
                <div class="alert alert-danger" role="alert">入力した値が正しくありません。</div>
                @endif
                </div>

                <button type="submit" class="btn btn-primary">作成</button>
            </form>
        </div>
    </div>
</div>
@endsection
