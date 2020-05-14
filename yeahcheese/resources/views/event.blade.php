@extends('layouts.template')

@section('title', 'イベント')

@section('content')
    @if(isset($event))
        <h2>{{ $event->title }}</h2><!-- eventのタイトル -->
    @else
        <h2>error</h2>
    @endif
    <!-- events.id == pictures.event_idのpictures.path -->
    <div>
    
    <p>しゃしん</p>
    </div>
@endsection
