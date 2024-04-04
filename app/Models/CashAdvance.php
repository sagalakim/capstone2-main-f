<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class CashAdvance extends Model
{
    use HasFactory;

    protected $attributes =[
        'amount' => 0,
    ];

    protected $fillable = [
        'amount',
    ];
}
