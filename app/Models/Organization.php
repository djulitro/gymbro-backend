<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'organizations';

    protected $fillable = ['name', 'description', 'address', 'phone', 'email', 'logo'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
