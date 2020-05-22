@extends('layouts.template')

@section('title', '認証キー入力')

@section('content')
<div class="container">
    <div class="row">
    <div class="col-md-4 offset-md-4">
        <h2 class="my-2">イベント閲覧</h2>
        <h1>認証キー入力</h1>
    </div>
    </div>
    <div class="row">
        <!--<div class="col-md-4 offset-md-4">-->
        <div class="col-md-4 offset-md-4">
            @if ($errors->any())
                <p class="d-flex align-item-center mb-0">{{ $errors->first() }}</p>
            @endif
        </div>
        <div class="col-md-4 offset-md-4">
        <form method="GET" action="{{ route('events.show') }}">
        <div class="form-group">
            <input type="text" class="form-control" name="auth_key" placeholder="認証キーを入力">
            <button type="submit" class="btn btn-primary mt-2">閲覧</button>
        </form>
        </div>
    </div>
</div>
@endsection
