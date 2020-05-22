@extends('layouts.template')

@section('title', 'イベント編集')

@section('content')
<!--CSS変更時にボタン位置など修正-->
    <h2>イベント編集</h2>
    <div id="update">
        <p>イベントタイトル</p>
        <input v-model="title">
        <p>公開開始日</p>
        <input type="date" v-model="release_date">
        <p>公開終了日</p>
        <input type="date" v-model="end_date">
        <button type="submit" @click="updateEvent">更新</button>
    </div>

    <script src="{{ asset('js/index.js') }}" data-event-id="@json($event->id)"></script>
@endsection
