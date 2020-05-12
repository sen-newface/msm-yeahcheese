@extends(layouts.template.blade.php)

@section('title', 'イベント一覧')

@section('content')
    <h2>イベント一覧</h2>
    <button>新規作成</button>
    <!-- $eventsはで現在のユーザが作成したイベントの配列が渡される想定です -->
    @foreach($events as $event)
        <div>
            <h3>{{ $event->title }}</h3>
            <!-- 枚数持ってくる処理が必要 -->
            <p>掲載期間：{{ $event->release_date }} - {{ $event->end_date }} 枚数：(eventに紐づいているpicturesの枚数) キー：{{ $event->auth_key }}</p>
            <a href="">編集ボタン</a>
        </div>
    @endforeach
@endsection
