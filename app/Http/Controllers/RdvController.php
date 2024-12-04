<?php

namespace App\Http\Controllers;

use App\Models\Medecin;
use App\Models\Patient;
use App\Models\Rdvs;
use App\Models\Schedule;
use App\Models\Specialites;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class RdvController extends Controller
{
    public function index(Request $request)
    {
        $dateFilter = $request->input('date_filter');
        $statusFilter = $request->input('etat_de_rdv');
        $specialiteFilter = $request->input('specialite_filter');
        $medecinFilter = $request->input('medecin_filter');
        
        $query = Rdvs::query();
    
        if ($dateFilter) {
            $query->whereHas('schedule', function ($q) use ($dateFilter) {
                $q->whereDate('date', $dateFilter);
            });
        }
    
        if ($statusFilter) {
            $query->where('etat_de_rdv', $statusFilter);
        }
    
        if ($specialiteFilter) {
            $query->whereHas('medecin', function($q) use ($specialiteFilter) {
                $q->where('specialites_id', $specialiteFilter);
            });
        }
    
        if ($medecinFilter) {
            $query->where('medecin_id', $medecinFilter);
        }
    
        $rdvs = $query->paginate(8);
        $patients = Patient::all();
        $specialites = Specialites::with('medecins.user')->get();
    
        return view('admin.rdvs.index', compact('rdvs','patients','specialites'));
    }

    public function create()
    {
        $patients = Patient::all();
        $specialites = Specialites::with('medecins.user')->get();;
        return view('admin.rdvs.create', compact('patients','specialites'));
    }
    public function getMedecinSchedules($medecinId)
    {
        $schedules = Schedule::where('medecin_id', $medecinId)
                            ->where('status', 'available')
                            ->orderBy('date')
                            ->orderBy('time')
                            ->get();
        
        return response()->json($schedules);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
            'schedule_id' => 'required|exists:schedules,id',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $schedule = Schedule::find($request->schedule_id);

        if ($schedule->date < now()) {
            if(now()->addDay()->format('D')==='Sun'){
                return redirect()->back()->withErrors(['schedule_id' => 'The selected date must be after Sunday.']);
            };
            return redirect()->back()->withErrors(['schedule_id' => 'The selected date must start from tomorrow.']);
        }

        if ($schedule->status !== 'available') {
            return redirect()->back()->with('error', 'The selected schedule is not available.');
        }

        $selectedDate = $schedule->date;
        $today = date('Y-m-d');
        if ($selectedDate < $today) {
            return redirect()->route('rdvs.index')->with('error', 'The selected date must be greater than today.');
        }

        Rdvs::create([
            'patient_id' => $request->patient_id,
            'medecin_id' => $schedule->medecin_id,
            'schedule_id' => $request->schedule_id,
        ]);

        // Update the schedule status
        $schedule->update(['status' => 'booked']);

        return redirect()->route('rdvs.index')->with('success', 'Appointment scheduled successfully.');
    }

    public function show(Rdvs $rdv)
    {
        return view('admin.rdvs.show', compact('rdv'));
    }

    public function edit($id)
    {
        $specialites = Specialites::with('medecins.user')->get();
        $rdv = Rdvs::find($id);
        if (!$rdv) {
            return redirect()->route('rdvs.index')->with('error', 'Rdv not found.');
        }
        $patient = Patient::find($rdv->patient_id);
        return view('admin.rdvs.edit', compact('rdv', 'patient', 'specialites'));
    }

    public function update(Request $request, $id)
    {
        $rdv = Rdvs::find($id);
        if (!$rdv) {
            return redirect()->route('rdvs.index')->with('error', 'Appointment not found.');
        }

        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'schedule_id' => 'required|exists:schedules,id',
        ]);


        $schedule = Schedule::findOrFail($validated['schedule_id']);

        if ($schedule->date < now()) {
            return redirect()->back()->withErrors(['schedule_id' => 'The selected date must start from tomorrow.']);
        }

        if ($schedule->status != 'available') {
            return redirect()->back()->with('error', 'The selected schedule slot is no longer available.');
        }

        $previousSchedule = Schedule::find($rdv->schedule_id);
        $previousSchedule->update(['status' => 'available']);

        $rdv->patient_id = $validated['patient_id'];
        $rdv->medecin_id = $schedule->medecin_id;
        $rdv->schedule_id = $schedule->id;
        $rdv->etat_de_rdv = 'encour';
        $rdv->save();

        

        $schedule->update(['status' => 'booked']);

        return redirect()->route('rdvs.index')->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Rdvs $rdv)
    {
        $rdv->delete();
        return redirect()->route('rdvs.index');
    }
    public function updateEtat(Request $request, $id)
{
    $rdv = Rdvs::findOrFail($id);
    $rdv->etat_de_rdv = $request->input('etat_de_rdv');
    $rdv->save();

    return redirect()->route('rdvs.index')->with('success', 'Appointment status updated successfully.');
}
    public function searchPatients(Request $request)
        {
            $searchTerm = $request->input('search');
            $patients = Patient::where('nom', 'like', "%{$searchTerm}%")
                                ->orWhere('prenom', 'like', "%{$searchTerm}%")
                                ->get(['id', 'nom', 'prenom']);
            return response()->json($patients);
        }

    public function availableDatesTimes(Medecin $medecin, $date)
        {
            // Retrieve available schedules for the given doctor and date
            $availableSlots = $medecin->schedules()
                                        ->where('date', $date)
                                        ->where('status', 'available') 
                                        ->get(['date', 'time'])
                                        ->map(function ($schedule) {
                                            return [
                                                'start' => $schedule->date . ' ' . $schedule->time,
                                                'end' => $schedule->date . ' ' . date('H:i', strtotime($schedule->time) + 1800) // Assuming each slot is 30 minutes
                                            ];
                                        });
        
            return response()->json([
                'availableSlots' => $availableSlots
            ]);
        }
    public function getMedecinsBySpecialite($specialiteId)
        {
            // Assuming that 'Medecin' has a relationship with 'User'
            $medecins = Medecin::where('specialites_id', $specialiteId)->with('user')->get();
            return response()->json($medecins);
        }

    public function getSchedulesByMedecin($medecinId)
        {
            $schedules = Schedule::where('medecin_id', $medecinId)
                                ->where('status', 'available')
                                ->orderBy('date')
                                ->orderBy('time')
                                ->get();
            return response()->json($schedules);
        }
        
}
