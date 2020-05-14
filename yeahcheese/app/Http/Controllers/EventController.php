<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Event;
use \App\Picture;

class EventController extends Controller
{
    public function index()
    {
        $id = Auth::id();
        $events = Event::where('user_id', $id)->with('pictures')->get();
        return view('events_list', ['events' => $events]);
    }

    /**
     * EventのAuth_key(8桁の文字列)を生成する
     * @param $str 文字列を受け取る(ここでは$event->titleを期待)
     * @param $generateKey $strとランダムに生成された8桁のバイト文字列を結合して格納する
     * @return $generateKeyから生成された8桁のハッシュ値を返す
     */
    private function generateHash($str)
    {
        $generateKey = $str . random_bytes(8);
        return hash('fnv132', $generateKey);
    }

    /**
     * イベント作成のページを表示する
     * @return event_create.blade.phpからビューを作成し、表示する
     */
    public function create()
    {
        return view('event_create');
    }

    /**
     * /events/create/ のページのフォーム情報を受け取り、保存する
     * @param $request POSTリクエストを受け取る(Eventモデルの$rulesでバリデーションを行う)
     * @param $form $requestの中からhtml側のformに格納された情報を取り出し、受け取る
     * @param $event 新規作成するEventの情報を格納する
     * @return イベント一覧画面を表示する
     */
    public function store(Request $request)
    {
        $this->validate($request, Event::$rules, Event::$messages);

        $form = $request->all();
        unset($form['_token']);

        $event = new Event;
        $event->user_id = Auth::id();
        $event->auth_key = $this->generateHash($event->title);
        $event->fill($form);

        $event->save();

        return redirect('events');
    }

    // TODO: resquestに認証キー
    public function show(Request $request)
    {
        $event = Event::where('auth_key', $request->auth_key)->first();
        // 今の段階で画像を登録する機能がないので画像は投げずにイベントのみ受け渡し
        // 画像の有無を確認する機能が必要
        //$picture = Picture::where('event_id', $event->id)->get();
        //$data = [['pictures' => $picture], ['event' => $event]];
        return view('event', ['event' => $event]);
    }

    public function search()
    {
        return view('search');
    }
}
