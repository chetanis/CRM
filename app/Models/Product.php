<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'category',
        'current_stock',
        'minimum_stock',
        'price',
        'sold',
    ];

    public function addStock(int $quantity)
    {
        $this->current_stock += $quantity;
        $this->save();
    }

    public function subtractStock(int $quantity)
    {
        $this->current_stock -= $quantity;
        if ($this->current_stock < 0) {
            $this->current_stock = 0;
        }
        $this->save();
    }
}
