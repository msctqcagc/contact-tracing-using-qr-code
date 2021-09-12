<?php

namespace App\Models;

use Cake\Chronos\Chronos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResidentDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'resident_id',
        'type',
        'file_name'
    ];

    public function setTypeAttribute($value) {
        $this->attributes['type'] = strtoupper($value);
    }

    public function filePath() {
        return asset('uploads/images/documents/' . $this->attributes['file_name']);
    }

    public function getCreatedAtAttribute() {
        return Chronos::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at']);
    }

    public function getUpdatedAtAttribute() {
        return Chronos::createFromFormat('Y-m-d H:i:s', $this->attributes['updated_at']);
    }
}
