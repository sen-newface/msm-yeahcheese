@extends('layouts.template')

@section('title', 'イベント作成')

@section('content')
    <h2>イベント新規作成</h2>
    <form method="POST" action="/events/">
        @csrf
        <h3>イベント名</h3>
        <input type="text" name="title">
        <h3>公開開始日</h3>
        <input type="date" name="release_date">
        <h3>公開終了日</h3>
        <input type="date" name="end_date">
        <input type="submit" value="作成">
    </form>
@endsection
