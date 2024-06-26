<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Command extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'user_id',
        'total_price',
        'type',
        'payment_method',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'price_at_sale')->withTimestamps();
    }

    // Define the relationship with the Client model
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getProductsAndQuantitiesAttribute()
    {
        return $this->products->map(function ($product) {
            return [
                'product_id' => $product->id,
                'name' => $product->name,
                'quantity' => $product->pivot->quantity,
                'price_at_sale' => $product->pivot->price_at_sale,
                'total_price' => $product->pivot->quantity * $product->pivot->price_at_sale,
            ];
        })->toArray();
    }

    // Define a scope to filter commands by type
    public function scopeFilter($query, array $filters)
    {
        if ($filters['type'] ?? false) {
            $query->where('type', $filters['type']);
        }

        if ($filters['client'] ?? false) {
            $query->whereHas('client', function ($client) use ($filters) {
                $client->where('first_name', 'LIKE', '%' . $filters['client'] . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $filters['client'] . '%');
            });
        }
    }

    public static function getAccessibleCommands()
    {
        // If the user is an admin or superuser, show all commands
        if (Auth::user()->privilege === 'admin' || Auth::user()->privilege === 'superuser') {
            return self::latest();
        } else {
            // If the user is a regular user, show only the commands created by them
            return self::where('commands.user_id', Auth::id())->latest();
        }
    }

    //change the user that is assigned to the commande
    public function changeAssignedTo(int $userId)
    {
        $this->user_id = $userId;
        $this->save();
    }
}
