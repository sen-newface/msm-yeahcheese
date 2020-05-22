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

    <div id="picture-list">
        <div class="container-fluid">
            <div class="row">
                <div class="col-4 my-2" v-for="p in pictures">
                    <picture-item
                        :received-path = 'p.path'
                    ></picture-item>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/index.js') }}" data-event-id="@json($event->id)"></script>
@endsection
