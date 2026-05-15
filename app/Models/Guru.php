<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Guru extends Model
{
   protected $fillable = [
        'user_id',
        'jenis_kelamin',
        'mapel',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
