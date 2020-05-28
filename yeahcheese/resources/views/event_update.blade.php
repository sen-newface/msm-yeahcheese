@extends('layouts.template')

@section('title', 'イベント編集')

@section('content')
<!--CSS変更時にボタン位置など修正-->
<div class="container">
    <div class="jumbotron bg-white border">
        <h2 class="">イベント編集</h2>
        <p class="text-secondary">ファイルを選択して写真を登録しましょう。</p>
    </div>

    <div id="app">
        <event-editor-component
            :event-id="{{ $event->id }}"></event-editor-component>
        <picture-component
            :event-id="{{ $event->id }}"></picture-component>
    </div>
</div>

    <script src="{{ asset('js/app.js') }}"></script>
@endsection
