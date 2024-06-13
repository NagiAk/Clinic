<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Medecin;
use App\Models\RDV;
use Illuminate\Support\Facades\Auth ;

class MedecinPatientController extends Controller
{
    public function index(Request $request)
    {
        $medecinId = Auth::user()->medecin->id; 

        $searchTerm = $request->input('search');

        $query = Patient::whereHas('rdvs', function($query) use ($medecinId) {
            $query->where('medecin_id', $medecinId);
        });

        if ($searchTerm) {
            $query->where(function($query) use ($searchTerm) {
                $query->where('nom', 'like', "%{$searchTerm}%")
                ->orWhere('prenom', 'like', "%{$searchTerm}%");
            });
        }

        $patients = $query->get();

        return view('medecin.patients.index', compact('patients'));
    }

    public function show($id)
    {
        $patient = Patient::find($id);
        return view('medecin.patients.show', compact('patient'));
    }

    public function edit($id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return redirect()->route('patients.index')->with('error', 'Patient not found.');
        }

        // Ensure the patient has an RDV with the authenticated medecin
        $medecinId = Auth::user()->medecin->id;
        if (!$patient->rdvs()->where('medecin_id', $medecinId)->exists()) {
            return redirect()->route('patients.index')->with('error', 'Unauthorized access to edit patient details.');
        }

        return view('medecin.patients.edit', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'cin' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255'
        ]);

        $patient = Patient::findOrFail($id);

        $medecinId = Auth::user()->medecin->id;
        if (!$patient->rdvs()->where('medecin_id', $medecinId)->exists()) {
            return redirect()->route('patients.index')->with('error', 'Unauthorized access to update patient details.');
        }

        $patient->nom = $request->nom;
        $patient->prenom = $request->prenom;
        $patient->cin = $request->cin;
        $patient->email = $request->email;
        $patient->phone = $request->phone;
        $patient->save();

        return redirect()->route('patients.index')->with('success', 'Patient updated successfully.');
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);

        $medecinId = Auth::user()->medecin->id;
        if (!$patient->rdvs()->where('medecin_id', $medecinId)->exists()) {
            return redirect()->route('patients.index')->with('error', 'Unauthorized access to delete patient details.');
        }

        $patient->delete();

        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully.');
    }
}
