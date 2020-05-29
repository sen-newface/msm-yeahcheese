<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\CarbonImmutable;
use App\Event;
use App\Http\Requests\StoreEventRequest;

class EventController extends Controller
{
    const EVENT_NUM_PER_PAGE = 5;

    public function index(Request $request)
    {
        $today = CarbonImmutable::now()->toDateString();
        $id = Auth::id();

        $events = Event::userIdEquals($id)
            ->with('pictures')
            ->when(isset($request['open']) && !isset($request['close']), function ($query) use ($today) {
                $query->releaseDateBeforeOrEquals($today)
                ->endDateAfterOrEquals($today);
            })
            ->when(isset($request['close']) && !isset($request['open']), function ($query) use ($today) {
                $query->where(function ($query) use ($today) {
                    return $query->releaseDateAfter($today)
                    ->orWhere(function ($query) use ($today) {
                        $query->endDateBefore($today);
                    });
                });
            })
            ->orderBy('id', 'DESC')
            ->paginate(self::EVENT_NUM_PER_PAGE);

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
    public function store(StoreEventRequest $request)
    {
        $form = $request->all();
        unset($form['_token']);

        $event = new Event;
        $event->user_id = Auth::id();
        $event->auth_key = $this->generateHash($event->title);
        $event->fill($form);

        $event->save();

        return redirect('events');
    }

    public function edit(Event $event)
    {
        if (Auth::id() === $event->user_id) {
            return view('event_update', ['event' => $event]);
        }

        // TODO リダイレクト時にイベントが見つらかなかったことを通知
        // TODO イベント一覧画面にエラー表示用の要素を用意してから
        return redirect('events');
    }

    public function show(Request $request)
    {
        $today = CarbonImmutable::today();

        $event = Event::authKeyEquals($request->auth_key)
            ->first();

        if (is_null($event)) {
            return redirect('events/search')->withErrors('イベントが見つかりませんでした。');
        }

        $pictures = $event->pictures()->get();

        if ($pictures->isEmpty()) {
            return view('event_show', [
                'event' => $event,
                'pictures' => $pictures,
            ])->with($request->auth_key)->withErrors('写真が登録されていません。');
        }

        return view('event_show', [
            'event' => $event,
            'pictures' => $pictures,
        ])->with($request->auth_key);
    }

    public function search()
    {
        return view('search');
    }
}
