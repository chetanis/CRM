<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'company_name',
        'job_title',
        'address',
        'industry',
        'lead_source',
        'notes',
        'social_media_profiles',
        'code_fiscal',
        'assigned_to',
    ];

    protected $casts = [
        'social_media_profiles' => 'array',
    ];

    // Define the relationship with the User model
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    // Define the relationship with the Appointment model
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    // Define the relationship with the Commands model
    public function commands()
    {
        return $this->hasMany(Command::class);
    }

    //get the clients that are accessible to the user
    public static function getAccessibleClients()
    {
        // If the user is an admin or superuser, show all clients
        if (Auth::user()->privilege === 'admin' || Auth::user()->privilege === 'superuser') {
            return self::latest();
        } else {
            // If the user is a regular user, show only the clients assigned to them
            return self::where('assigned_to', Auth::id())->latest();
        }
    }

    //change the user that is assigned to the client
    public function changeAssignedTo(int $userId)
    {
        $this->assigned_to = $userId;
        $this->save();
    } 

}
