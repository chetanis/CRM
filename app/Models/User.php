<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password', 'privilege','full_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    // Define a scope to filter users by type
    public function scopeFilter($query, array $filters)
    {
        if($filters['type'] ?? false){
            $query->where('privilege', $filters['type']);
        }
    }
    // Define the relationship with the Client model
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    //get the clients of the user
    public function getClients()
    {
        return Client::where('assigned_to', $this->id)->latest()->get();
    }

    //get the commands of the user
    public function getCommands()
    {
        return Command::where('user_id', $this->id)->latest()->get();
    }
}
