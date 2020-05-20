@extends('layouts.template')

@section('title', 'イベント編集')

@section('content')
    <h2>イベント編集</h2>
    <div id="update">
        <p>イベントタイトル</p>
        <input v-model="title">
        <p>公開開始日</p>
        <input v-model="release_date">
        <p>公開終了日</p>
        <input v-model="end_date">
    </div>

    <script src="{{ asset('js/index.js') }}"></script>
@endsection
