<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medecin extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'specialite_id'];

    /**
     * Get the user associated with the medecin.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the specialite associated with the medecin.
     */
    public function specialite()
    {
        return $this->belongsTo(Specialite::class);
    }
    public function rdvs()
    {
        return $this->hasMany(Rdv::class, 'medecin_id');
    }
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
