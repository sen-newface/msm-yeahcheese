@extends('layouts.template')

@section('title', '認証キー入力')

@section('content')
    <h2>イベント閲覧</h2>
    <h1>認証キー入力</h1>
    <div>
    @if ($errors->any())
        <p>{{ $errors->first() }}</p>
    @endif
        <form method="GET" action="{{ route('events.show') }}">
            <input type="text" name="auth_key" placeholder="認証キーを入力">
            <button type="submit">閲覧</button>
        </form>
    </div>
@endsection
