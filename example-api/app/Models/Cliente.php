<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'name',
        'balance',
    ];

    public $hidden = [
        'created_at',
        'updated_at'
    ];
}
