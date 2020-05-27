@extends('layouts.template')

@section('title', 'イベント')

@section('content')
<div class="container">
    <div class="jumbotron bg-white border">
        <h2>{{ $event->title }}</h2>
        <p>掲載期間 : {{ $event->release_date }} / {{ $event->end_date }}</p>
        <p class="text-secondary">画像をクリックすると拡大表示されます</p>
    </div>

    <div class="container">
        <div class="row">
            <!-- 写真一覧表示 -->
            @if ($errors->any())
                <p class="col">{{ $errors->first() }}</p>
            @endif
            
            @foreach($pictures as $picture)
            <div class="col-sm-4 my-2 d-flex align-items-center justify-content-center">
                <img src="{{ \Storage::url($picture->path) }}" class="show_item" data-toggle="modal" data-target="#picture{{ $picture->id }}">
            </div>

            <div class="modal fade" id="picture{{ $picture->id }}">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <img src="{{ \Storage::url($picture->path) }}" class="aligncenter size-full w-100">
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
