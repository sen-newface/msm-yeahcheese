@extends('layouts.template')

@section('title', 'イベント')

@section('content')
    <div>
    @if(!is_null($event))
        <p>{{ $event }}</p>
        <h2>{{ $event->title }}</h2><!-- eventのタイトル -->
        <!-- 写真一覧表示 -->
        @if(!empty($pictures))
            <p>わわわ〜</p>
            <p>{{ $pictures }}</p>
            @foreach($pictures as $picture)
            <div>
                <!-- events.id == pictures.event_idのpictures.path -->
                <img src="{{ \Storage::url($picture->path) }}" style="width:250px">
            </div>
            @endforeach
        @else
            <p>{{ $pictures }}</p>
            <p>画像はまだ登録されていません</p>
        @endif
    @else
        <h2>イベントが見つかりませんでした</h2>
    @endif
    </div>
@endsection
