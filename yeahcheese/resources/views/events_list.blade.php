@extends('layouts.template')

@section('title', 'イベント一覧')

@section('content')
    <h2>イベント一覧</h2>
    <a href="{{ route('events.create') }}">
        <button>新規作成</button>
    </a>
    <!-- $eventsはで現在のユーザが作成したイベントの配列が渡される想定です -->
    @foreach($events as $event)
        @if($event->end_date >= $today)
            <div>
                <h3>{{ $event->title }}</h3>
                <p>掲載期間：{{ $event->release_date }} - {{ $event->end_date }} 枚数：{{ $event->pictures->count() }}／キー：{{ $event->auth_key }}
                    <a href="{{ route('events.update') }}">編集する</a>
                </p>
            </div>
        @endif
    @endforeach
@endsection
