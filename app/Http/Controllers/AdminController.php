<?php

namespace App\Http\Controllers;

use App\Models\Medecin;
use App\Models\Patient;
use App\Models\Rdvs;
use App\Models\Specialites;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     * Show the form for creating a new resource.
     */
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function dashboard()
    {
        $patientsCount = Patient::count();
        $rdvsCount = Rdvs::count();
        $medecinsCount = Medecin::count();

        $realiserCount = Rdvs::where('etat_de_rdv', 'realise')->count();
        $annulerCount = Rdvs::where('etat_de_rdv', 'annuler')->count();
        $encourCount = Rdvs::where('etat_de_rdv', 'encour')->count();

        $rdvStatus = [$realiserCount, $annulerCount, $encourCount];

        $specialites = Specialites::all();
        return view('admin.dashboard', compact('patientsCount', 'rdvsCount', 'medecinsCount', 'rdvStatus', 'specialites'));
    }
}
