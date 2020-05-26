@extends('layouts.template')

@section('title', 'イベント編集')

@section('content')
<!--CSS変更時にボタン位置など修正-->
    <div id="app">
        <event-editor-component
            :event-id="{{ $event->id }}"></event-editor-component>
        <picture-component
            :event-id="{{ $event->id }}"></picture-component>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
@endsection
