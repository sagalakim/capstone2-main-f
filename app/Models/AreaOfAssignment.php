<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaOfAssignment extends Model
{
    use HasFactory;

    protected $table = 'area_of_assignment';

    protected $fillable = [
        'region_name',
    ];
}
