@extends('layouts.template')

@section('title', 'イベント')

@section('content')
<div class="container">
    <div class="jumbotron bg-white border">
        <h2>{{ $event->title }}</h2>
        <p>掲載期間 : {{ $event->release_date }} / {{ $event->end_date }}</p>
    </div>

    <div class="container-fluid">
    <div class="row">
        <!-- 写真一覧表示 -->
        @if ($errors->any())
            <p>{{ $errors->first() }}</p>
        @endif
        @foreach($pictures as $picture)
        <div class="col-4 my-2 d-flex align-items-center">
            <img src="{{ \Storage::url($picture->path) }}" class="show_item">
        </div>
        @endforeach
    </div>
    </div>
</div>
@endsection
