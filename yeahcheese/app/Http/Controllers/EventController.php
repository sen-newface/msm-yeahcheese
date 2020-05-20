<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\CarbonImmutable;
use App\Event;

class EventController extends Controller
{
    public function index()
    {
        $id = Auth::id();
        $events = Event::userIdEquals($id)
            ->with('pictures')
            ->get();

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

    public function update(Request $request)
    {
    }

    // TODO: resquestに認証キー
    public function show(Request $request)
    {
        $today = CarbonImmutable::now()->toDateString();

        $event = Event::authKeyEquals($request->auth_key)
            ->releaseDateBeforeOrEquals($today)
            ->endDateAfter($today)
            ->first();

        if (!is_null($event)) {
            $pictures = $event->pictures()->get();

            return view('event', [
                'event' => $event,
                'pictures' => $pictures,
            ])->with($request->auth_key);
        } else {
            return redirect('events/search')->withErrors('イベントが見つかりませんでした。');
        }
    }

    public function search()
    {
        return view('search');
    }
}
