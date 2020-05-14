@extends('layouts.template')

@section('title', 'イベント')

@section('content')
    <div>
    @if(isset($event))
        <h2>{{ $event->title }}</h2><!-- eventのタイトル -->
    @else
        <h2>error</h2>
    @endif
    <!-- events.id == pictures.event_idのpictures.path -->
    <!-- 写真一覧表示 -->
    @if(isset($pictures))
        @foreach($pictures as $picture)
        <div>
            <img src="{{ \Storage::url($picture->path) }}" style="width:250px">
        </div>
        @endforeach
    @else
        <p>画像はまだ登録されていません</p>
    @endif
    </div>
@endsection
