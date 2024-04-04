<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Account;
use App\Models\Product;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Itinerary extends Model
{
    use HasFactory;

    protected $attributes =[
        'remarks' => '',
        
    ];

    protected $fillable = [
        'itin_head',
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

    //protected $with = ['approver'];
    /*
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }
    */

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
