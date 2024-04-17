<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Command extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'user_id',
        'products',
        'total_price',
        'type',
        'payment_method',
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

    // Define a scope to filter commands by type
    public function scopeFilter($query, array $filters)
    {
        if($filters['type'] ?? false){
            $query->where('type', $filters['type']);
        }
    }

    public static function getAccessibleCommands()
    {
        // If the user is an admin or superuser, show all commands
        if (Auth::user()->privilege === 'admin' || Auth::user()->privilege === 'superuser') {
            return self::latest();
        } else {
            // If the user is a regular user, show only the commands created by them
            return self::where('user_id', Auth::id())->latest();
        }
    }

    //change the user that is assigned to the commande
    public function changeAssignedTo(int $userId)
    {
        $this->user_id = $userId;
        $this->save();
    }

}
