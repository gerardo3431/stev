<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'description',
        'note',
    ];

    // public function user(){
    //     return $this->belongsToMany(User::class, 'logs', 'user_id');
    // }

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
