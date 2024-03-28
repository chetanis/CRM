<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'user_id',
        'products',
        'total_price',
        'type',
    ];

    protected $casts = [
        'products' => 'array',
    ];

    // Define the relationship with the Client model
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define a method to retrieve products with quantities
    public function getProductsAndQuantitiesAttribute()
    {
        $productsData = $this->products;
        $productIds = array_column($productsData, 'id');

        // Fetch the products from the database based on the product IDs
        $products = Product::whereIn('id', $productIds)->get();
        $productsWithQuantities = [];

        foreach ($productsData as $productData) {
            $productId = $productData['id'];
            $quantity = $productData['quantity'];
            $product = $products->where('id', $productId)->first();

            if ($product) {
                $productsWithQuantities[] = [
                    'product' => $product,
                    'quantity' => $quantity
                ];
            }
        }

        return $productsWithQuantities;
    }
}
