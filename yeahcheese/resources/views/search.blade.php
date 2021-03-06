@extends('layouts.template')

@section('title', '認証キー入力')

@section('content')
<div class="container">
    <div class="jumbotron bg-white border">
        <h2>イベント閲覧</h2>
        <p class="text-secondary">イベントの認証キーを入力するとイベントを閲覧することができます。</p>
    </div>

    <div class="row">
        <!--<div class="col-md-4 offset-md-4">-->
        <div class="col-md-6 offset-md-3">
            @if ($errors->any())
            <div class="alert alert-danger" role="alert">{{ $errors->first() }}</div>
            @endif
        </div>
        <!-- フォームとボタンだけinlineになるように修正する -->
        <div class="col-md-6 offset-md-3">
            <form method="GET" action="{{ route('events.show') }}">
                <h4>認証キー</h4>
                <div class="form-group form-row form-inline">
                    <input type="text" class="form-control col" name="auth_key" placeholder="認証キーを入力">
                    <button type="submit" class="btn btn-primary mx-2">閲覧</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
