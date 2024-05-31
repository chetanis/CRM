<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Notifications\Notifiable;

// class User extends Authenticatable
// {
//     use HasFactory, Notifiable;

//     /**
//      * The attributes that are mass assignable.
//      *
//      * @var array
//      */
//     protected $fillable = [
//         'username', 'password', 'privilege','full_name','notes'
//     ];

//     /**
//      * The attributes that should be hidden for arrays.
//      *
//      * @var array
//      */
//     protected $hidden = [
//         'password',
//     ];

//     // Define a scope to filter users by type
//     public function scopeFilter($query, array $filters)
//     {
//         if ($filters['type'] ?? false) {
//             $query->where('privilege', $filters['type']);
//         }
//     }
//     // Define the relationship with the Client model
//     public function appointments()
//     {
//         return Appointment::where('user_id', $this->id)->latest()->get();
//     }

//     //get the clients of the user
//     public function getClients()
//     {
//         return Client::where('assigned_to', $this->id)->latest()->get();
//     }

//     // Define the relationship with the Client model
//     public function clients()
//     {
//         return $this->hasMany(Client::class, 'assigned_to');
//     }


//     //get the commands of the user
//     public function getCommands()
//     {
//         return Command::where('user_id', $this->id)->latest()->get();
//     }
// }

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username', 'password', 'privilege', 'full_name', 'notes'
    ];

    protected $hidden = [
        'password',
    ];

    public function scopeFilter($query, array $filters)
    {
        if ($filters['type'] ?? false) {
            $query->where('privilege', $filters['type']);
        }
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'user_id');
    }

    public function clients()
    {
        return $this->hasMany(Client::class, 'assigned_to');
    }

    public function commands()
    {
        return $this->hasMany(Command::class, 'user_id');
    }

    public static function getUserActivity($startDate = null, $endDate = null)
    {
        // If no start date or end date is provided, set them to a range that covers all possible dates
        if (!$startDate) {
            $startDate = '1970-01-01 00:00:00'; // Unix epoch start date
        }
        if (!$endDate) {
            // Set the end date to today's date
            $endDate = date('Y-m-d H:i:s');
        }
        $userActivity = [];

        $all_users = self::with(['clients','commands', 'appointments'])->get();

        foreach ($all_users as $user) {
            $nb_clients = $user->clients->count();
            $commands = $user->commands->whereBetween('created_at', [$startDate, $endDate]);
            $totalCommands = $commands->count();
            $confirmedCommands = $commands->where('type', 'done')->count();
            $cancelledCommands = $commands->where('type', 'cancelled')->count();
            $totalAppointments = $user->appointments->whereBetween('date_and_time', [$startDate, $endDate])->count();

            $gains = $commands->where('type', 'done')->sum('total_price');

            $userActivity[] = [
                'nb_clients' => $nb_clients,
                'user_name' => $user->username,
                'total_commands' => $totalCommands,
                'confirmed_commands' => $confirmedCommands,
                'cancelled_commands' => $cancelledCommands,
                'total_appointments' => $totalAppointments,
                'gains' => $gains,
            ];
        }

        return $userActivity;
    }
}
