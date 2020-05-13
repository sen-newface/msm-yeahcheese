<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function users()
    {
        return $this->belongsTo('App\User');
    }
    public function pictures()
    {
        return $this->hasMany('App\Picture');
    }

    protected $fillable = [
        'title',
        'release_date',
        'end_date',
    ];
}
