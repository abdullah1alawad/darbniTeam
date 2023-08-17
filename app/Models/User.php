<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'uuid',
        'specialization_id',
        'phone','role',
        'code',
        'photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'code','created_at','updated_at','id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id'=>'integer',
        'uuid'=>'string',
        'specialization_id'=>'integer',
        'username'=>'string',
        'phone'=>'string',
        'role'=>'boolean',
        'photo'=>'string',
        'code'=>'string',
    ];

    //------------------------------------------------------

    protected function getCodeAttribute()
    {
        return Crypt::decrypt($this->attributes['code']);
    }

    //-------------------------------------------------------

    public function favorites() : HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function complaints() : HasMany
    {
        return $this->hasMany(Complaint::class);
    }

    public function image() : MorphOne
    {
        return $this->morphOne(Imageable::class,'imageable');
    }


}
