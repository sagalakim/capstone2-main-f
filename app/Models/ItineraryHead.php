<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Itinerary;

class ItineraryHead extends Model
{
    use HasFactory;

    protected $attributes =[
        'approved_by' => null,
        'approver_role' => '',
        'status' => 'Pending'
    ];

    protected $fillable = [
        'user_id',
        'date_from',
        'date_to',
        'status',
        'approved_by',
        'approver_role',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }

    public function itineraries()
    {
        return $this->hasMany(Itinerary::class, 'itin_head', 'id');
    }
}
