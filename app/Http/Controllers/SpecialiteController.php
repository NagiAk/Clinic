<?php

namespace App\Http\Controllers;

use App\Models\Specialite;
use Illuminate\Http\Request;

class SpecialiteController extends Controller
{
    public function index()
    {
        $specialites = Specialite::all();
        return view('admin.specialites.index', compact('specialites'));
    }

    public function create()
    {
        return view('admin.specialites.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:specialites'
        ]);
        $splt = new Specialite();
        $splt->nom=$request->input('nom');
        $splt->save();
        return redirect()->route('specialites.index');
    }

    public function show($id)
    {
        $specialite = Specialite::findOrFail($id);
        return view('admin.specialites.show', compact('specialite'));
    }

    public function edit(Specialite $specialite)
    {
        return view('admin.specialites.edit', compact('specialite'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:specialites,nom,' . $id
        ]);
        $splt = Specialite::findOrFail($id);
        $splt->nom=$request->input('nom');
        $splt->save();
        return redirect()->route('specialites.index');
    }

    public function destroy(Specialite $specialite)
    {
        $specialite->delete();
        return redirect()->route('specialites.index');
    }
}
