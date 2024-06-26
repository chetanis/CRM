<?php

namespace App\Models;

use App\Models\ProductNotif;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'current_stock',
        'minimum_stock',
        'price',
        'purchase_price',
        'sold',
        'on_hold',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function commands(): BelongsToMany
    {
        return $this->belongsToMany(Command::class)->withPivot('quantity', 'price_at_sale')->withTimestamps();
    }

    public function addStock(int $quantity)
    {
        $old_stock = $this->current_stock;
        $this->current_stock += $quantity;
        $this->save();

        //if the stock was below the minimum stock and now it is above delete the notification
        if ($old_stock < $this->minimum_stock && $this->current_stock >= $this->minimum_stock) {
            ProductNotif::where('product_id', $this->id)->delete();
        }
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

    public function getTotalRevenueFromConfirmedCommands()
    {
        return $this->commands()
                    ->where('type', 'done')
                    ->sum(DB::raw('command_product.quantity * command_product.price_at_sale'));
    }
}
