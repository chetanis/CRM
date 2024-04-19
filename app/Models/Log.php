<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'details',
    ];

    // Define the relationship with the User model
    public function user(){
        return $this->belongsTo(User::class);
    }

    public static function CreateLog($action, $details)
    {
        // Fetch the authenticated user's ID
        $userId = auth()->id();

        // Create a new log entry
        self::create([
            'user_id' => $userId,
            'action' => $action,
            'details' => $details,
        ]);
    }
}
