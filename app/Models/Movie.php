<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['title', 'description', 'poster_url', 'trailer_url', 'duration'];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($movie) {
            $movie->schedules()->delete();
        });
    }
}

