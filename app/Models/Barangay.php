<?php

namespace App\Models;

use Cake\Chronos\Chronos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barangay extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'chairman',
        'chairman_contact_number',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    public function getCreatedAtAttribute() {
        return Chronos::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at']);
    }

    public function getUpdatedAtAttribute() {
        return Chronos::createFromFormat('Y-m-d H:i:s', $this->attributes['updated_at']);
    }
}
