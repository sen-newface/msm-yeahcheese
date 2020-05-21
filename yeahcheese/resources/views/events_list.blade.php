@extends('layouts.template')

@section('title', 'イベント一覧')

@section('content')
    <h2>イベント一覧</h2>
    <a href="{{ route('events.create') }}">
        <button>新規作成</button>
    </a>
    <!-- $eventsはで現在のユーザが作成したイベントの配列が渡される想定です -->
    @foreach($events as $event)
        <div>
            <h3>{{ $event->title }}</h3>
            <p>掲載期間：{{ $event->release_date }} - {{ $event->end_date }} 枚数：{{ $event->pictures->count() }}／キー：{{ $event->auth_key }}
                <a href="{{ route('events.edit', ['auth_key' => $event->auth_key]) }}">編集する</a><br>
            </p>
            @foreach($event->pictures as $picture)
                <div class="picture">
                    <img class="picture-thumbnail" src="{{ \Storage::url($picture->path) }}"><br>
                    Updated<br>{{ $picture->edit->format('Y/m/d H:i') }}
                </div>
            @endforeach
        </div>
    @endforeach
@endsection
