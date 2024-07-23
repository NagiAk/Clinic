<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medecin extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'specialites_id'];

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
        return $this->belongsTo(Specialites::class,'specialites_id');
    }
    public function rdvs()
    {
        return $this->hasMany(Rdvs::class, 'medecin_id');
    }
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
