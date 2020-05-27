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

    public function scopeUserIdEquals($query, $id)
    {
        return $query->where('user_id', $id);
    }

    public function scopeAuthKeyEquals($query, $auth_key)
    {
        return $query->where('auth_key', $auth_key);
    }

    public function scopeEndDateAfter($query, $date)
    {
        return $query->where('end_date', '>', $date);
    }

    public function scopeEndDateBefore($query, $date)
    {
        return $query->where('end_date', '<', $date);
    }

    public function scopeEndDateBeforeOrEquals($query, $date)
    {
        return $query->where('end_date', '<=', $date);
    }

    public function scopeReleaseDateAfter($query, $date)
    {
        return $query->where('release_date', '>', $date);
    }

    public function scopeReleaseDateBefore($query, $date)
    {
        return $query->where('release_date', '<', $date);
    }

    public function scopeReleaseDateBeforeOrEquals($query, $date)
    {
        return $query->where('release_date', '<=', $date);
    }

    protected $fillable = [
        'title',
        'release_date',
        'end_date',
    ];
}
