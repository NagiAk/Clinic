<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MedecinScheduleController extends Controller
{
    public function index(Request $request)
    {
        $medecin = Auth::user()->medecin;
        $dateFilter = $request->input('date_filter');

    // Retrieve schedules for the medecin, optionally filtering by date
        $query = Schedule::where('medecin_id',$medecin->id);

        if ($dateFilter) {
            $query->whereDate('date', $dateFilter);
        }
        else{
            $dateFilter = now()->toDateString();
            $query->whereDate('date', $dateFilter );
        }

        $schedules = $query->get();

        return view('medecin.schedule.index', compact('schedules','dateFilter'));
    }

    

    

}
