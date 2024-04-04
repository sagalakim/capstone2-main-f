<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Itinerary;
use App\Models\Accomplishment;
use App\Models\Liquidation;
use App\Models\ItineraryHead;
use App\Models\AccomplishmentHead;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $attributes =[
        'area_id' => 1,
    ];

    protected $fillable = [
        'firstname',
        'lastname',
        'phone',
        'email',
        'password',
        'role',
        'area_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(): Attribute {
        return new Attribute(
            get: fn($value) => ['agents','rsm','asm','nsm_nl', 'nsm_fl', 'executive_assistant','general_admin'][$value],
        );
    }

    public function itinerary_heads()
    {
        return $this->hasMany(ItineraryHead::class);
    }

    public function accomplishment_heads()
    {
        return $this->hasMany(AccomplishmentHead::class);
    }

    public function accomplishments()
    {
        return $this->hasMany(Accomplishment::class);
    }

    public function liquidations()
    {
        return $this->hasMany(Liquidation::class);
    }
}
