<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
