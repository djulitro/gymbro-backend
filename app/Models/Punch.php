<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Punch extends Model
{
    use HasFactory;

    protected $table = 'punches';

    protected $fillable = ['organization_id', 'user_id', 'punch_type_id', 'punch_in', 'confirm_admin_id'];

    protected $hidden = ['created_at', 'updated_at'];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function punchType()
    {
        return $this->belongsTo(PunchType::class);
    }

    public function confirmAdmin()
    {
        return $this->belongsTo(User::class, 'confirm_admin_id');
    }
}
