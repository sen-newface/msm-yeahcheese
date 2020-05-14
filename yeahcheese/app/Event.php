<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function pictures()
    {
        return $this->hasMany('App\Picture');
    }

    public static $rules = [
        'title' => ['required', 'max:255'],
        'release_date' => ['required', 'date', 'after_or_equal:today', 'before:end_date'],
        'end_date' => ['required', 'date', 'after:today', 'after:release_date'],
    ];

    public static $messages = [
        'title.required' => 'イベントタイトルは必須項目です',
        'title.max' => 'イベントタイトルは255文字まで設定できます',

        'release_date.required' => 'イベント公開開始日は必須項目です',
        'release_date.date' => 'イベント公開開始日は日付形式で入力してください',
        'release_date.after_or_equal' => 'イベント公開開始日は本日以降の日付である必要があります',
        'release_date.before' => 'イベント公開開始日はイベント公開終了日より前の日付である必要があります',

        'end_date.required' => 'イベント公開終了日は必須項目です',
        'end_date.date' => 'イベント公開終了日は日付形式で入力してください',
        'end_date.after' => 'イベント公開開始日は明日より後の日付である必要があります',
        'end_date.after' => 'イベント公開終了日はイベント公開開始日より後の日付である必要があります',
    ];

    protected $fillable = [
        'title',
        'release_date',
        'end_date',
    ];
}
