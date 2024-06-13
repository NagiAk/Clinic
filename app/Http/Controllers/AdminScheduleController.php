<?php

namespace App\Http\Controllers;

use App\Models\Medecin;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminScheduleController extends Controller
{
    public function index(Request $request)
    {
        $medecins = Medecin::all();
        $selectedMedecinId = $request->input('medecin_id');
        $dateFilter = $request->input('date_filter');

        if ($selectedMedecinId) {
            $selectedMedecin = Medecin::findOrFail($selectedMedecinId);
            $query = Schedule::where('medecin_id', $selectedMedecinId);

            if ($dateFilter) {
                $query->whereDate('date', $dateFilter);
            } else {
                $dateFilter = now()->toDateString();
                $query->whereDate('date', $dateFilter);
            }

            $schedules = $query->get();
        } else {
            $selectedMedecin = null;
            $schedules = null;
        }

        return view('admin.schedule.index', compact('medecins', 'schedules', 'dateFilter', 'selectedMedecin'));
    }

    public function generateWeeklySchedule()
    {
        $medecins = Medecin::all();
        return view('admin.schedule.generate',compact('medecins'));
    }

    public function storeWeeklySchedule(Request $request)
    {
        $medecin = Medecin::findOrFail($request->input('medecin_id')) ;

        if (!$medecin) {
            return redirect()->back()->with('error', 'No medecin found for the current user.');
        }


        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $dayOfWeek = $date->format('l');

            if (in_array($dayOfWeek, $days)) {
                if ($dayOfWeek == 'Saturday') {
                    $startTime = Carbon::createFromTime(9, 0);
                    $endTime = Carbon::createFromTime(12, 0);
                } else {
                    $startTime = Carbon::createFromTime(9, 0);
                    $endTime = Carbon::createFromTime(16, 0);
                }

                for ($time = $startTime; $time->lt($endTime); $time->addMinutes(30)) {
                    Schedule::create([
                        'medecin_id' => $medecin->id,
                        'date' => $date->toDateString(),
                        'time' => $time->format('H:i'),
                        'status' => 'available',
                    ]);
                }
            }
        }

        return redirect()->route('schedule.index')->with('success', 'Schedule a ete creer successfully.');
    }

}
