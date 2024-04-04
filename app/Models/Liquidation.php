<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Liquidation extends Model
{
    use HasFactory;

    protected $attributes =[
        'liquidated_by' => null,
        'checked_by' => null,
        'recommending_approval' => null,
        'approved_by' => null,
    ];

    protected $fillable = [
        'user_id',
        'activity',
        'employee_name',
        'position',
        'date_filed',
        'inclusive_date',
        'status',
        'liquidated_by',
        'checked_by',
        'recommending_approval',
        'approved_by',
    ]; 

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
