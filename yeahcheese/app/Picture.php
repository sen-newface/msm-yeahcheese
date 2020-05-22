<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    public function event()
    {
        return $this->belongsTo('App\Event');
    }

    public static $rules = [
        'file' => ['required', 'file', 'mimes:jpeg,jpg', 'between:100,1024'],
    ];

    public static $messages = [
        'file.mimes' => 'jpgまたはjpeg形式にしてください',
        'file.between' => '100KB以上、1MB以下の画像にしてください',
    ];

    protected $fillable = [
        'path',
        'event_id'
    ];
}
