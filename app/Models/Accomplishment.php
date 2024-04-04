<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Accomplishment extends Model
{
    use HasFactory;

    protected $attributes =[
        'remarks' => '',
        
    ];

    protected $fillable = [
        'itin_head',
        'accomplishment_head',
        'area_id',
        'user_id',
        'date',
        'name_of_coop',
        'municipality',
        'account_id',
        'purpose',
        'product_id',
        'remarks',
        /*
        'status',
        'approved_by',
        'approver_role',
        */
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
