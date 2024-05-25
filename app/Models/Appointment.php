<?php

namespace App\Models;

use DateTime;
use Carbon\Carbon;
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
            return self::where('appointments.user_id', Auth::id())->latest();
        }
    }

    public static function getTodayAccessibleAppointments(){

        $today = Carbon::now()->toDateString();

        if (Auth::user()->privilege === 'admin' || Auth::user()->privilege === 'superuser') {
            return self::whereDate('date_and_time', $today)
            ->orderBy('date_and_time', 'asc')
            ->get();
        }else{
            return self::where('appointments.user_id', Auth::id())
            ->orderBy('date_and_time', 'asc')
            ->whereDate('date_and_time', $today)
            ->get(); 
        }
    }

    public function getHour(){
        $date = new DateTime($this->date_and_time);
        return $date->format('H:i');
    }

    //change the user that is assigned to the appointment
    public function changeAssignedTo(int $userId)
    {
        $this->user_id = $userId;
        $this->save();
    }
}
