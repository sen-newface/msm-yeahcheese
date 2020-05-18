@extends('layouts.template')

@section('title', 'イベント')

@section('content')
    <div>
        <h2>{{ $event->title }}</h2><!-- eventのタイトル -->
        <!-- 写真一覧表示 -->
        @foreach($pictures as $picture)
        <div>
            <img src="{{ \Storage::url($picture->path) }}" style="width:250px">
        </div>
        @endforeach
    </div>
@endsection
