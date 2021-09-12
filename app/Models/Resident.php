<?php

namespace App\Models;

use Cake\Chronos\Chronos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function barangay() {
        return $this->belongsTo(Barangay::class, 'barangay_id');
    }

    public function getCreatedAtAttribute() {
        return Chronos::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at']);
    }

    public function getUpdatedAtAttribute() {
        return Chronos::createFromFormat('Y-m-d H:i:s', $this->attributes['updated_at']);
    }

    public function documents() {
        return $this->hasMany(ResidentDocument::class, 'resident_id');
    }
}
