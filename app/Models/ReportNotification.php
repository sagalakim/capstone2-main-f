<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ItineraryHead;

class ReportNotification extends Model
{
    use HasFactory;

    protected $attributes =[
        'itinerary_id' => null,
        'accomplishment_id' => null,
        'liquidation_id' => null,
        'status' => '',
    ];

    protected $fillable = [
        'user_id',
        'itinerary_id',
        'accomplishment_id',
        'liquidation_id',
        'status',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function report()
    {
        return $this->belongsTo(ItineraryHead::class, 'itinerary_id', 'id');
    }
}
