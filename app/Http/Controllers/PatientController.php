<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    public function index()
    {
        $query = Patient::query();
        $patients = $query->paginate(6);
        return view('admin.patients.index', compact('patients'));
    }

    public function create()
    {
        return view('admin.patients.create');
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',  
            'phone' => 'nullable|numeric|max_digits:10|min_digits:10',
            'email' => 'required|string|email|max:255|unique:patients',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string|max:255',
            'cin' => 'required|string|max:255'
        ]);
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        }
        $ptn = new Patient();
        $ptn->nom=$request->input('nom');
        $ptn->prenom=$request->input('prenom');
        $ptn->phone=$request->input('phone');
        $ptn->email=$request->input('email');
        $ptn->gender=$request->input('gender');
        $ptn->address=$request->input('address');
        $ptn->cin=$request->input('cin');
        $ptn->save();
        return redirect()->route('patients.index');
    }

    public function show(Patient $patient)
    {
        return view('admin.patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('admin.patients.edit', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'phone' => 'nullable|numeric',
            'email' => 'required|string|email|max:255|unique:patients,email,' . $id,
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string|max:255',
            'cin' => 'required|string|max:255'
        ]);
        $ptn = Patient::findOrFail($id);
        $ptn->nom=$request->input('nom');
        $ptn->prenom=$request->input('prenom');
        $ptn->phone=$request->input('phone');
        $ptn->email=$request->input('email');
        $ptn->gender=$request->input('gender');
        $ptn->address=$request->input('address');
        $ptn->cin=$request->input('cin');
        $ptn->save();
        return redirect()->route('patients.index');

    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index');
    }

    public function home(){
        return view('main.home');

    }
}
