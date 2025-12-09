<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    protected $fillable = [
        'name'
    ];

    public $hidden = [
        'created_at',
        'updated_at'
    ];

    public function produtos()
    {
        return $this->hasMany(\App\Models\Produtos::class, 'category_id');
    }
}
