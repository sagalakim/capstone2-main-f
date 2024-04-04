<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class LiquidationData extends Model
{
    use HasFactory;

    protected $attributes =[
        'user_id' => null,
        'liquidation_id' => null,
        'date' => null,
        'travel_itinerary_from' => null,
        'travel_itinerary_to' => null,
        'reference' => null,
        'particulars' => null,
        'transpo' => null,
        'hotel' => null,
        'meals' => null,
        'sundry' => null,
        'amount' => null,
        'row_total' => null,
        'total' => '',
        'cash_advance' => '',
        'for_or' => '',
    ];

    protected $fillable = [
        'user_id',
        'liquidation_id',
        'date',
        'travel_itinerary_from',
        'travel_itinerary_to',
        'reference',
        'particulars',
        'transpo',
        'hotel',
        'meals',
        'sundry',
        'amount',
        'row_total',
        'total',
        'cash_advance',
        'for_or',
    ]; 

    public $formattedDate;
    
}
