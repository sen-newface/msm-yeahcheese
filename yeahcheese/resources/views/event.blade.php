@extends('layouts.template')

@section('title', 'イベント')

@section('content')
    <div>
    @if(isset($event))
        <h2>{{ $event->title }}</h2><!-- eventのタイトル -->
    @else
        <h2>error</h2>
    @endif
    <!-- ここに写真が入ります -->
    <!-- events.id == pictures.event_idのpictures.path -->
    </div>
@endsection
