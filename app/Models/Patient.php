<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    public function rdvs()
    {
        return $this->hasMany(Rdvs::class, 'patient_id');
    }
}
