<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentRequest;
use App\Models\Specialite;
use Illuminate\Validation\Rule;

class AppointmentController extends Controller
{
    public function form()
    {
        $specialites = Specialite::all();
        return view('form.form',compact('specialites'));
    }

    public function sendAppointmentRequest(Request $request)
    {
        $cinPattern = '/^[A-Za-z](?=.{7}$)\d{7}|[A-Za-z]{2}(?=.{6}$)\d{6}$/';
        $phonePattern = '/^\d{10}$/';

        $validatedData = $request->validate([
            'name' => 'required|string',
            'cin' => ['required', 'string', 'regex:' . $cinPattern],
            'email' => 'required|email',
            'phone' => ['required', 'string', 'regex:' . $phonePattern],
            'specialite' => 'required|exists:specialites,id',
            'availability' => 'required|date|after:today',
        ], [
            'cin.regex' => 'Le CIN doit suivre le format spécifié.',
            'phone.regex' => 'Le numéro de téléphone doit comporter 10 chiffres.',
            'availability.after' => "La date de rendez-vous doit être postérieure à la date d'aujourd'hui.",
        ]);
        
        $specialite = Specialite::findOrFail($validatedData['specialite']);
        $validatedData['specialite'] = $specialite->nom;

        Mail::to('stagechu1@gmail.com')->send(new AppointmentRequest($validatedData));

        return redirect()->back()->with('success', 'Votre demande de rendez-vous a été envoyée avec succès!');
    }
}
