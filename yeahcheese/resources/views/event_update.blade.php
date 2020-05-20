@extends('layouts.template')

@section('title', 'イベント編集')

@section('content')
    <h2>イベント編集</h2>

    <div id="update">
        <p>@{{name}}</p>
    </div>

    <script src="{{asset('js/index.js')}}"></script>
@endsection
