@extends('layouts.template')

@section('title', 'イベント')

@section('content')
<div class="container">
    <div class="jumbotron">
        <h2 class="">{{ $event->title }}</h2>
    </div>

    <div class="container-fluid">
    <div class="row">
        <!-- 写真一覧表示 -->
        @foreach($pictures as $picture)
        <div class="col-4 my-2">
            <img src="{{ \Storage::url($picture->path) }}" width="100%" class="img img-thumbnail">
        </div>
        @endforeach
    </div>
    </div>
</div>
@endsection
