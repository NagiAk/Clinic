<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medecin;

class InfoController extends Controller
{
    public function contact()
    {
        return view('contact');
    }

    public function services()
    {
        return view('services');
    }

    public function doctors()
    {
        $doctors = Medecin::all(); 
        return view('doctors', compact('doctors'));
    }
    public function about()
    {
        return view('about');
    }
    public function terms()
    {
        return view('terms');
    }
    public function health()
    {
        return view('health_policy');
    }

    
}
