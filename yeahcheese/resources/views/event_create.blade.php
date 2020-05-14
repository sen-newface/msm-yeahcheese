@extends('layouts.template')

@section('title', 'イベント作成')

@section('content')
    <h2>イベント新規作成</h2>
    <form method="POST" action="/events/">
        @csrf
        <h3>イベント名</h3>
        <input type="text" name="title" value="{{ old('title') }}">
        @if($errors->has('title'))
        <p>{{ $errors->first('title') }}</p>
        @endif
        <h3>公開開始日</h3>
        <input type="date" name="release_date" value="{{ old('release_date') }}">
        @if($errors->has('release_date'))
        <p>{{ $errors->first('release_date') }}</p>
        @endif
        <h3>公開終了日</h3>
        <input type="date" name="end_date" value="{{ old('end_date') }}">
        @if($errors->has('end_date'))
        <p>{{ $errors->first('end_date') }}</p>
        @endif
        @if($errors->any())
        <hr>
        <p>入力した値が正しくありません。</p>
        @endif
        <input type="submit" value="作成">
    </form>
@endsection
