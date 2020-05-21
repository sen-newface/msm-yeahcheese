@extends('layouts.template')

@section('title', 'イベント一覧')

@section('content')
<div class="container">
    <div class="row">
        <h2 class="col-md-6 offset-md-3 text-center">イベント一覧</h2>
    </div>
    <div class="row">
    <a class="col-md-2 offset-md-5" href="{{ route('events.create') }}">
        <button type="button" class="btn btn-primary btn-lg btn-block">新規作成</button>
    </a>
    </div>
    <!-- $eventsはで現在のユーザが作成したイベントの配列が渡される想定です -->
    <div class="row">
    @foreach($events as $event)
        <div class="col-md-6 offset-md-3 text-center">
            <div class="card">
            <h3 class="card-title">{{ $event->title }}</h3>
            <p class="card-text">掲載期間：{{ $event->release_date }} - {{ $event->end_date }} 枚数：{{ $event->pictures->count() }}／キー：{{ $event->auth_key }}</p>
                <a href="{{ route('events.update') }}" ><button type="button" class="btn btn-primary">編集する</button></a>
            <div class="row">
            @foreach($event->pictures as $picture)
                <div class="col-md-4">
                    <img class="img img-thumbnail" src="{{ Storage::url($picture->path) }}"><br>
                    <!--Updated<br>{{ $picture->updated_at->format('Y/m/d H:i') }}-->
                </div>
            @endforeach
            </div>
            </div>
        </div>
    @endforeach
    </div>
</div>
@endsection
