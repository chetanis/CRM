<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'client_id',
        'date_and_time',
        'purpose',
        'status',
    ];

    protected $dates = ['date_and_time'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    //get the appointments that the user can access
    public static function getAccessibleAppointments()
    {
        if (Auth::user()->privilege === 'admin' || Auth::user()->privilege === 'superuser') {
            return self::latest();
        }else{
            return self::where('user_id', Auth::id())->latest();
        }
    }
}
