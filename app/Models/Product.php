<?php

namespace App\Models;

use App\Models\ProductNotif;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'purchase_price',
        'sold',
    ];

    public function commands(): BelongsToMany
    {
        return $this->belongsToMany(Command::class)->withPivot('quantity', 'price_at_sale')->withTimestamps();
    }

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
        //check if the current stock is below the minimum stock
        if ($this->current_stock < $this->minimum_stock) {
            //create a product notification
            ProductNotif::create([
                'product_id' => $this->id,
                'message' => 'Le stock de ' . $this->name . ' est inférieur au stock minimum'
            ]);
        }
        $this->save();
    }
}
