<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialite extends Model
{
    use HasFactory;

    /**
     * Get the medecins associated with the specialite.
     */
    public function medecins()
    {
        return $this->hasMany(Medecin::class);
    }

    /**
     * Get the rdvs associated with the specialite.
     */
    
}
