<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Testing\Fluent\Concerns\Has;

class Specialization extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [

    ];

    public function codes() : HasMany
    {
        return $this->hasMany(Code::class);
    }

    public function books() : HasMany
    {
        return $this->hasMany(Book::class);
    }

    public function exams() : HasMany
    {
        return $this->hasMany(Exam::class);
    }

    public function subjects() : HasMany
    {
        return $this->hasMany(Subject::class);
    }

    public function image() : MorphOne
    {
        return $this->morphOne(Imageable::class,'imageable');
    }

}
