<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    protected $table = 'residents';

    protected $guarded = [];

    public function complaints(){
        return $this->hasMany(Complaint::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
