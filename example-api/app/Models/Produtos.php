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
}
