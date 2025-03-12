<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'payments';

    protected $fillable = ['organization_id', 'user_id', 'subcription_id', 'start_date', 'end_date'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subcription()
    {
        return $this->belongsTo(Subcription::class);
    }
}
