<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Question extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'subject_id',
        'question','reference'
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

    public function favorites() : HasMany
    {
        return $this->HasMany(Favorite::class);
    }

    public function answers() : HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function subject() :BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function questionable() : MorphTo
    {
        return $this->morphTo();
    }



}
