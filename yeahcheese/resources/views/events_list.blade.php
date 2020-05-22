@extends('layouts.template')

@section('title', 'イベント一覧')

@section('content')
<div class="container">
    <div class="jumbotron">
        <h2 class="">イベント一覧</h2>
        <a href="{{ route('events.create') }}"><button type="button" class="btn btn-primary btn-lg">新規作成</button></a>
    </div>
    <!-- ユーザーが作成した全イベント情報を表示 --> 
    @foreach($events as $event)
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h3 class="card-header">{{ $event->title }}</h3>
                <div class="card-body row">
                    <div class="col-md-4">
                        <p class="card-text">
                            掲載期間：{{ $event->release_date }} - {{ $event->end_date }}<br>
                            枚数：{{ $event->pictures->count() }}<br>
                            キー：{{ $event->auth_key }}
                        </p>
                        <a class="btn btn-primary" href="{{ route('events.edit', ['event' => $event]) }}" role="button">編集する</a>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            @foreach($event->pictures as $picture)
                                @if ($loop->iteration <= 3)
                                    <div class="col-md-4">
                                        <img class="img img-thumbnail" width="80%" src="{{ Storage::url($picture->path) }}">
                                    </div>
                                @else
                                    @break
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    </div>
</div>
@endsection
