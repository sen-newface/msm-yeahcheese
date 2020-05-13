<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    public function events(){
        return $this->belongsTo('App\Event');
    }
    protected $fillable = [
        'path',
    ];
}
