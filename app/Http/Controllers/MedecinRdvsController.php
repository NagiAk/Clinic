<?php

namespace App\Http\Controllers;


use App\Models\Rdv;
use App\Models\Patient;
use App\Models\Schedule;
use App\Models\Specialite;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class MedecinRdvsController extends Controller
{
    public function index(Request $request)
    {
        $mdId = Auth::user()->medecin->id;

        $dateFilter = $request->input('date_filter');
        $statusFilter = $request->input('etat_de_rdv');

        $rdvs = RDV::where('medecin_id', $mdId)
                    ->with(['patient', 'schedule']);

        if ($dateFilter) {
            $rdvs->whereHas('schedule', function ($rd) use ($dateFilter) {
                $rd->whereDate('date', $dateFilter);
            });
        }

        if ($statusFilter) {
            $rdvs->where('etat_de_rdv', $statusFilter);
        }

        $rdvs = $rdvs->get();

        return view('medecin.rdvs.index', compact('rdvs'));
    }


    public function create()
    {
        $patients = Patient::all();
        $medecinId = Auth::user()->medecin->id;
        $schedules = Schedule::where('medecin_id', $medecinId)
                            ->where('status', 'available')
                            ->orderBy('date')
                            ->orderBy('time')
                            ->get();

        return view('medecin.rdvs.create', compact('patients', 'schedules'));
    }
    

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'schedule_id' => 'exists:schedules,id',
        ]);

        $schedule = Schedule::findOrFail($validated['schedule_id']);
        
        if ($schedule->status != 'available') {
            return redirect()->back()->with('error', 'The selected schedule slot is no longer available.');
        }

        $rdv = new Rdv();
        $rdv->patient_id = $validated['patient_id'];
        $rdv->medecin_id = $schedule->medecin_id;
        $rdv->schedule_id = $schedule->id;
        $rdv->etat_de_rdv = 'encour';
        $rdv->save();

        $schedule->status = 'booked';
        $schedule->save();

        return redirect()->route('medecin.rdvs.index')->with('success', 'Appointment booked successfully.');
    }

    public function show(Rdv $rdv)
    {
        return view('medecin.rdvs.show', compact('rdv'));
    }

    public function edit( $id)  // Change Rdv $rdv to $id
    {
        $patients = Patient::all();
        $medecinId = Auth::user()->medecin->id;
        $schedules = Schedule::where('medecin_id', $medecinId)
                            ->where('status', 'available')
                            ->orderBy('date')
                            ->orderBy('time')
                            ->get();
        $rdv = Rdv::find($id);
        if (!$rdv) {
            return redirect()->route('medecin.rdvs.index')->with('error', 'Rdv not found.');
        }
        return view('medecin.rdvs.edit', compact('rdv','patients','schedules'));
    }

    public function update(Request $request,$id)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'schedule_id' => 'required|exists:schedules,id',
        ]);
        $rdv = RDV::findOrFail($id);

        $oldScheduleId = $rdv->schedule_id;
        $oldSchedule = Schedule::findOrFail($oldScheduleId);
        $oldSchedule->status = 'available';
        $oldSchedule->save();

        $schedule = Schedule::findOrFail($validated['schedule_id']);
        
        if ($schedule->status != 'available') {
            return redirect()->back()->with('error', 'The selected schedule slot is no longer available.');
        }

        $rdv->patient_id = $validated['patient_id'];
        $rdv->medecin_id = $schedule->medecin_id;
        $rdv->schedule_id = $schedule->id;
        $rdv->etat_de_rdv = 'encour';
        $rdv->save();

        $schedule->status = 'booked';
        $schedule->save();

        return redirect()->route('medecin.rdvs.index')->with('success', 'Appointment booked successfully.');
    }

    public function destroy(Rdv $rdv)
    {
        $rdv->delete();
        return redirect()->route('medecin.rdvs.index');
    }
    public function updateEtat(Request $request, $id)
    {
        $rdv = Rdv::findOrFail($id);
        $rdv->etat_de_rdv = $request->input('etat_de_rdv');
        $rdv->save();

        return redirect()->route('medecin.rdvs.index')->with('success', 'Appointment status updated successfully.');
    }
    public function searchPatients(Request $request)
        {
            $searchTerm = $request->input('search');
            $patients = Patient::where('nom', 'like', "%{$searchTerm}%")
                                ->orWhere('prenom', 'like', "%{$searchTerm}%")
                                ->get(['id', 'nom', 'prenom']);
            return response()->json($patients);
        }

}
