@extends('layouts.template')

@section('title', 'イベント')

@section('content')
<div class="container">
    <div class="row">
        <div class="col text-center"><h2>{{ $event->title }}</h2></div><!-- eventのタイトル -->
    </div>
    <div class="row">
        <!-- 写真一覧表示 -->
        @foreach($pictures as $picture)
        <div class="col text-center">
            <img src="{{ \Storage::url($picture->path) }}" style="width:250px">
        </div>
        @endforeach
    </div>
</div>
@endsection
