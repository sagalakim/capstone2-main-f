<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
