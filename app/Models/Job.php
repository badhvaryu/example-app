<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;

class Job extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'job_listings';

//    protected $fillable = ['title', 'salary', 'employer_id'];

    protected $guarded = [];

    public function employer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }

    public function tags(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Tag::class, foreignPivotKey: "job_listing_id"); // we have to provide foreignPivotKey because eloquent model not the same as table e.g. Model= Job Table = job_listings
    }
}
