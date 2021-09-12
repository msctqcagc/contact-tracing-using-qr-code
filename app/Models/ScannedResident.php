<?php

namespace App\Models;

use Cake\Chronos\Chronos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScannedResident extends Model
{
    use HasFactory;

    protected $casts = [
        'is_active_case' => 'boolean'
    ];

    // public function getCreatedAtAttribute() {
    //     return Chronos::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at']);
    // }

    public function getUpdatedAtAttribute() {
        return Chronos::createFromFormat('Y-m-d H:i:s', $this->attributes['updated_at']);
    }

    public function resident() {
        return $this->belongsTo(Resident::class, 'resident_id');
    }

    public function scanner() {
        return $this->belongsTo(Scanner::class, 'scanner_id');
    }
}
