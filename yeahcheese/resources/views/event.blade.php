@extends(layouts.template)

@section('title', 'イベント')

@section('content')
    <h2>{{ $data->$event->title }}</h2><!-- eventのタイトル -->
    <!-- events.id == pictures.event_idのpictures.path -->
    <div>
    @foreach($pictures as $picture)<!-- 写真一覧表示 -->
        <img src="{{ \Storage::url($image->path }}" style="width:250px">
    @endforeach
    </div>
@endsection
