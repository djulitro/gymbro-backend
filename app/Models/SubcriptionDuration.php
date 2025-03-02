<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubcriptionDuration extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'day_durations',];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
