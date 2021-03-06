@extends('layouts.template')

@section('title', 'イベント一覧')

@section('content')
<div class="container">
    <div class="jumbotron bg-white border">
        <h2 class="">イベント一覧</h2>
        <p class="text-secondary">イベントタイトルをクリックするとイベント画面を表示する事ができます。</p>
        <a href="{{ route('events.create') }}"><button type="button" class="btn btn-outline-primary btn-lg">新規作成</button></a>
    </div>

    <form  class="mb-4" method="get" action="/events">
        <div class="form-check form-check-inline">
            <label class="checkbox-inline">
                <input
                    class="form-check-input"
                    type="checkbox"
                    name="open"
                    value="1"
                    {{ isset($_GET['open']) ? "checked" : "" }}
                    >公開中のイベント
            </label>
            <label class="checkbox-inline ml-2">
                <input
                    class="form-check-input"
                    type="checkbox"
                    name="close"
                    value="1"
                    {{ isset($_GET['close']) ? "checked" : "" }}
                    >公開期間外のイベント
            </label>
            <button type="submit" class="btn btn-primary mx-2">絞り込む</button>
        </div>
    </form>

    <!-- ユーザーが作成した全イベント情報を表示 -->
    @foreach($events as $event)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <a class="text-body" href="{{ route('events.show', ['auth_key' => $event->auth_key]) }}"><h3 class="card-header">{{ $event->title }}</h3></a>
                <div class="card-body row">
                    <div class="col-md-4">
                        <p class="card-text">
                            掲載期間：{{ $event->release_date }} / {{ $event->end_date }}<br>
                            枚数：{{ $event->pictures->count() }}<br>
                            キー：{{ $event->auth_key }}
                        </p>
                        <a class="btn btn-outline-primary btn-lg" href="{{ route('events.edit', ['event' => $event]) }}" role="button">編集する</a>
                    </div>
                    <div class="col-md-8">
                        <div class="row m-2">
                            @foreach($event->pictures->take(3) as $picture)
                                <div class="col-4 d-flex align-items-center justify-content-center">
                                    <div class="border rounded">
                                        <img class="list_thumbnail m-2" src="{{ Storage::url($picture->path) }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    {{ $events->appends(request()->input())->links() }}
</div>
@endsection
