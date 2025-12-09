<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produtos extends Model
{
    protected $fillable = [
        'name',
        'price',
        'category_id',
        'stock_quantity'
    ];

    protected $hidden = [
        'category_id',
        'created_at',
        'updated_at'
    ];

    public function category()
    {
        return $this->belongsTo(Categorias::class, 'category_id');
    }

}

