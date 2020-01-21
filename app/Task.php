<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //dont guard anything
    protected $guarded = [];

    public function diary()
    {
        return $this->belongsTo(Diary::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
