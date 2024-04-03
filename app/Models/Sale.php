<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = [
        'command_id',
        'user_id',
    ];
    // Define the relationship with the Command model
    public function command()
    {
        return $this->belongsTo(Command::class);
    }

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //get accessible sales
    public static function getAccessibleSales()
    {
        // If the user is an admin or superuser, show all sales
        if (Auth::user()->privilege === 'admin' || Auth::user()->privilege === 'superuser') {
            return self::latest();
        } else {
            // If the user is a regular user, show only the sales they made
            return self::where('user_id', Auth::id())->latest();
        }
    }
}
