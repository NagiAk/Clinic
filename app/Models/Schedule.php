<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'medecin_id', 'date', 'time', 'status',
    ];

    public function medecin()
    {
        return $this->belongsTo(Medecin::class);
    }
}
