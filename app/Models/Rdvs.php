<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rdvs extends Model
{
    use HasFactory;
    protected $fillable = ['patient_id', 'medecin_id', 'schedule_id', 'etat_de_rdv'];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function medecin()
    {
        return $this->belongsTo(Medecin::class, 'medecin_id');
    }
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
