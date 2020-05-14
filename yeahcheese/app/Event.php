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
        'release_date' => ['required', 'date', 'after:today', 'before:end_date'],
        'end_date' => ['required', 'date', 'after:release_date'],
    ];

    public static $messages = [
        'title.required' => 'イベントタイトルは必須項目です',
        'title.max' => 'イベントタイトルは255文字まで設定できます',
    ];

    protected $fillable = [
        'title',
        'release_date',
        'end_date',
    ];
}
