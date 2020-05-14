@extends('layouts.template')

@section('title', 'イベント')

@section('content')
    <div>
    @if(!is_null($event))
        <h2>{{ $event->title }}</h2><!-- eventのタイトル -->
        <!-- 写真一覧表示 -->
        @foreach($pictures as $picture)
        <div>
            <!-- events.id == pictures.event_idのpictures.path -->
            <img src="{{ \Storage::url($picture->path) }}" style="width:250px">
        </div>
        @endforeach
    @else
        <h2>イベントが見つかりませんでした</h2>
    @endif
    </div>
@endsection
