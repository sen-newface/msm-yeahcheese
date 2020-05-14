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
    ];

    protected $fillable = [
        'title',
        'release_date',
        'end_date',
    ];
}
