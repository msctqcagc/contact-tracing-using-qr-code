<?php

namespace App\Models;

use Cake\Chronos\Chronos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function getCreatedAtAttribute() {
        return Chronos::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at']);
    }

    public function getUpdatedAtAttribute() {
        return Chronos::createFromFormat('Y-m-d H:i:s', $this->attributes['updated_at']);
    }
}
