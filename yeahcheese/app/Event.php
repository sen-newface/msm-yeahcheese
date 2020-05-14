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

    public static $rules = array(
    );

    protected $fillable = [
        'title',
        'release_date',
        'end_date',
    ];
}
