@extends('layouts.template')

@section('title', 'イベント編集')

@section('content')
<!--CSS変更時にボタン位置など修正-->
    <h2>イベント編集</h2>
    <div id="update">
        <p>イベントタイトル</p>
        <input v-model="title">
        <p>@{{ title_error_msg }}</p>

        <p>公開開始日</p>
        <input type="date" v-model="release_date">
        <p>@{{ error_release_date_msg }}</p>

        <p>公開終了日</p>
        <input type="date" v-model="end_date">
        <p>@{{ error_end_date_msg }}</p>

        <button type="submit" @click="updateEvent">更新</button>

        <p>@{{ message }}</p>
    </div>

    <script src="{{ asset('js/index.js') }}" data-event-id="@json($event->id)"></script>
@endsection
