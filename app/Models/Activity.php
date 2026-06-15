<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Activity extends Model
{
    protected $fillable = ['judul','description','icon'];

    protected static function booted()
    {
        static::creating(function ($activity) {
            if (!$activity->user_id) {
                $activity->user_id = Auth::id();
            }
        });
    }
}