<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Produtos;

class TabItem extends Model
{
    protected $fillable = [
        'tab_id', 
        'product_id', 
        'quantity', 
        'unit_price', 
        'total_price'];

    public function product()
    {
        return $this->belongsTo(Produtos::class);
    }
}
