<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
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
}
