<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PunchType extends Model
{
    use HasFactory;

    protected $table = 'punch_types';

    protected $fillable = ['name'];
}
