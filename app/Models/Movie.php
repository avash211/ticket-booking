<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Movie extends Model
{
    protected $fillable = [
    'title',
    'description',
    'date',
    'time',
    'img',
    'age_rating',
    'runtime',
    'year',
    'language',
    'genres',
    'director',
    'cast',
    'slug',
    'trailer'];

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
    public function getSlugAttribute()
    {
        return Str::slug($this->title);
    }
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }

    public function showTimes()
    {
        return $this->hasMany(ShowTime::class);
    }
    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }
}
