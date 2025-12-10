<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TabItem;

class Tab extends Model
{
    protected $fillable = [
        'customer_id', 
        'total', 
        'is_open'];

    public function items()
    {
        return $this->hasMany(TabItem::class);
    }
}
