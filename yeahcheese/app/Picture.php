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
        'file_size.max' => '最大容量は200MBです',
        // 'file.min' => '100KB以上の画像にしてください',
    ];

    protected $fillable = [
        'path',
        'event_id'
    ];
}
