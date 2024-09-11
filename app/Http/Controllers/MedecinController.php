<?php

namespace App\Http\Controllers;

use App\Models\Medecin;
use App\Models\Specialites;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MedecinController extends Controller
{
    public function MedPatient(){
        $id = Auth::user()->id;
        $Med = Medecin::findOrFail($id);
        return view('');
    }
    public function create()
    {
        
        $specialites = Specialites::all();
        return view('admin.medecins.create', compact('specialites'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'specialite_id' => 'required|exists:specialites,id',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'medecin';
        $user->save();

        // Create a new Medecin instance
        $medecin = new Medecin();
        $medecin->user_id = $user->id; // Associate the Medecin with the newly created User
        $medecin->specialites_id = $request->specialite_id;
        $medecin->save();

        return redirect()->route('medecins.create')->with('success', 'Medecin created successfully!');
    }
    public function show($id)
    {
        $medecin = Medecin::with('user', 'specialite')->findOrFail($id);
        return view('admin.medecins.show', compact('medecin'));
    }

    public function edit($id)
    {
        $medecin = Medecin::with('user')->findOrFail($id);
        $specialites = Specialites::all();
        return view('admin.medecins.edit', compact('medecin', 'specialites'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'specialite_id' => 'required|exists:specialites,id',
        ]);

        $medecin = Medecin::findOrFail($id);
        $user = User::findOrFail($medecin->user_id);
        
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        $medecin->specialite_id = $request->specialite_id;
        $medecin->save();

        return redirect()->route('medecins.index')->with('success', 'Medecin updated successfully!');
    }

    public function destroy($id)
    {
        $medecin = Medecin::findOrFail($id);
        $user = User::findOrFail($medecin->user_id);

        $medecin->delete();
        $user->delete();

        return redirect()->route('medecins.index')->with('success', 'Medecin deleted successfully!');
    }
    public function getMedecinsBySpecialite(Request $request)
    {
        $specialiteId = $request->query('specialite_id');
        $medecins = Medecin::with('user')
            ->where('specialite_id', $specialiteId)
            ->get();

        return response()->json([
            'medecins' => $medecins
        ]);
    }
}
