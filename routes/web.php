<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminScheduleController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GmailController;
use App\Http\Controllers\GmailAuthController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\MedecinPatientController;
use App\Http\Controllers\MedecinProfileController;
use App\Http\Controllers\MedecinRdvsController;
use App\Http\Controllers\MedecinScheduleController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpecialiteController;
use App\Http\Controllers\RdvController;
use App\Http\Controllers\ValidationController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUserRole;
use Illuminate\Support\Facades\URL;

if (app()->environment('production')) {
    URL::forceScheme('https');
}

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [PatientController::class, 'home'])->name('home');

// Route::get('/emails', [GmailController::class, 'index'])->name('emails.index')->middleware("auth");;
// Route::get('/search-patients', [RdvController::class, 'searchPatients'])->name('search-patients');




// Route::resource('patients', PatientController::class)->middleware("auth");
// Route::resource('specialites', SpecialiteController::class)->middleware("auth");
// Route::resource('rdvs', RdvController::class)->middleware("auth");
// Route::post('rdvs/{id}/updateEtat', [RdvController::class, 'updateEtat'])->name('rdvs.updateEtat')->middleware('auth');

Route::get('login',[AuthController::class,"login"])->name("login");
Route::post('toLogin',[AuthController::class,"toLogin"])->name("toLogin");
Route::delete('/logout',[AuthController::class,"logout"])->name("logout");

Route::get('/form',[AppointmentController::class,"form"])->name("form");
Route::post('/form',[AppointmentController::class,"sendAppointmentRequest"])->name("sendForm");


// Route::get('/profile', [ProfileController::class,'show'])->name('profile.show')->middleware('auth');
// Route::get('/profile/edit', [ProfileController::class,'edit'])->name('profile.edit')->middleware('auth');
// Route::put('/profile/update', [ProfileController::class,'update'])->name('profile.update')->middleware('auth');
// Route::get('/profile/password', [ProfileController::class, 'passwordForm'])->name('profile.password')->middleware('auth');
// Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('Pwupdate')->middleware('auth');

Route::middleware(['web', 'auth', CheckUserRole::class .':admin'])->group(function () {

    Route::get('admin/emails', [GmailAuthController::class, 'index'])->name('emails.index');
    Route::get('/auth/callback', [GmailAuthController::class, 'authenticate'])->name('auth.callback');
    Route::post('/validation/process',[ValidationController::class,'processValidation'])->name('validation.process');
    Route::get('admin/emails/filtered', [GmailAuthController::class, 'DateFilter'])->name('emails.filter');
    Route::get('admin/search-patients', [RdvController::class, 'searchPatients'])->name('search-patients');

    Route::get('/auth/callback', [GmailAuthController::class, 'authenticate'])->name('auth.callback');
    Route::post('/validation/process',[ValidationController::class,'processValidation'])->name('validation.process');

    Route::resource('admin/patients', PatientController::class);
    Route::resource('admin/specialites', SpecialiteController::class);
    Route::resource('admin/rdvs', RdvController::class);
    Route::get('/api/medecins/{medecin}/available-dates-times/{date}', [RdvController::class, 'availableDatesTimes']);
    Route::get('admin/{speciality}/medecins', [RdvController::class, 'getMedecinsBySpeciality']);
    Route::get('admin/{medecin}/schedules', [RdvController::class, 'getSchedulesByMedecin']);


    Route::resource('admin/medecins', MedecinController::class);
    Route::get('admin/medecins', [MedecinController::class, 'getMedecinsBySpecialite']);

    Route::post('admin/rdvs/{id}', [RdvController::class, 'updateEtat'])->name('rdvs.updateEtat');


    Route::get('admin/profile', [ProfileController::class,'show'])->name('profile.show');
    Route::get('admin/profile/edit', [ProfileController::class,'edit'])->name('profile.edit');
    Route::put('admin/profile/update', [ProfileController::class,'update'])->name('profile.update');
    Route::get('admin/profile/password', [ProfileController::class, 'passwordForm'])->name('profile.password');
    Route::post('admin/profile/update-password', [ProfileController::class, 'updatePassword'])->name('Pwupdate');

    // Route::get('/admin/addMededcin', [AdminController::class, 'createMed'])->name('addMed');
    // Route::post('/admin/addMededcin', [AdminController::class, 'storeMed'])->name('storeMed');

    Route::get('admin/schedule', [AdminScheduleController::class, 'index'])->name('schedule.index');
    Route::get('admin/schedule/generate', [AdminScheduleController::class, 'generateWeeklySchedule'])->name('schedule.generate');
    Route::post('admin/schedule/store', [AdminScheduleController::class, 'storeWeeklySchedule'])->name('schedule.store');
    Route::get('/admin/{medecinId}/schedules', [RdvController::class, 'getMedecinSchedules']);

    Route::get('admin/dashboard',[AdminController::class,'dashboard'])->name('dashboard');

});

// Medecin Routes
Route::middleware(['web', 'auth', CheckUserRole::class .':medecin'])->group(function () {
    // Route::resource('medecin/rdvs', MedecinRdvsController::class);
    Route::get('medecin/rdvs', [MedecinRdvsController::class, 'index'])->name('medecin.rdvs.index');
    Route::get('medecin/rdvs/create', [MedecinRdvsController::class, 'create'])->name('medecin.rdvs.create');
    Route::post('medecin/rdvs', [MedecinRdvsController::class, 'store'])->name('medecin.rdvs.store');
    Route::get('medecin/rdvs/{rdv}', [MedecinRdvsController::class, 'show'])->name('medecin.rdvs.show');
    Route::get('medecin/rdvs/{rdv}/edit', [MedecinRdvsController::class, 'edit'])->name('medecin.rdvs.edit');
    Route::put('medecin/rdvs/{rdv}', [MedecinRdvsController::class, 'update'])->name('medecin.rdvs.update');
    Route::delete('medecin/rdvs/{rdv}', [MedecinRdvsController::class, 'destroy'])->name('medecin.rdvs.destroy');
    Route::get('medecin/search-patients', [MedecinRdvsController::class, 'searchPatients'])->name('medecin.search-patients');
    Route::post('medecin/rdvs/{id}', [MedecinRdvsController::class, 'updateEtat'])->name('medecin.rdvs.updateEtat');
    Route::get('medecin/rdvs/{id}/download-pdf', [MedecinRdvsController::class, 'downloadRdvPdf'])->name('medecin.rdvs.downloadPdf');


    // Route::resource('medecin/patients', MedecinPatientController::class);
    Route::get('medecin/patients', [MedecinPatientController::class, 'index'])->name('medecin.patients.index');
    Route::get('medecin/patients/create', [MedecinPatientController::class, 'create'])->name('medecin.patients.create');
    Route::post('medecin/patients', [MedecinPatientController::class, 'store'])->name('medecin.patients.store');
    Route::get('medecin/patients/{pt}', [MedecinPatientController::class, 'show'])->name('medecin.patients.show');
    Route::get('medecin/patients/{pt}/edit', [MedecinPatientController::class, 'edit'])->name('medecin.patients.edit');
    Route::put('medecin/patients/{pt}', [MedecinPatientController::class, 'update'])->name('medecin.patients.update');
    Route::delete('medecin/patients/{pt}', [MedecinPatientController::class, 'destroy'])->name('medecin.patients.destroy');

    

    Route::get('medecin/profile', [MedecinProfileController::class, 'show'])->name('medecin.profile.show');
    Route::get('medecin/profile/edit', [MedecinProfileController::class, 'edit'])->name('medecin.profile.edit');
    Route::put('medecin/profile', [MedecinProfileController::class, 'update'])->name('medecin.profile.update');
    Route::get('medecin/profile/password', [MedecinProfileController::class, 'passwordForm'])->name('medecin.profile.password');
    Route::put('medecin/profile/update-password', [MedecinProfileController::class, 'updatePassword'])->name('medecin.Pwupdate');

    Route::get('medecin/schedule', [MedecinScheduleController::class, 'index'])->name('medecin.schedule.index');

});


Route::get('/contact', [InfoController::class, 'contact'])->name('contact.index');
Route::get('/aboutUs', [InfoController::class, 'about'])->name('about.index');
Route::get('/terms', [InfoController::class, 'terms'])->name('terms.index');
Route::get('/health_policy', [InfoController::class, 'health'])->name('health.index');
Route::get('/services', [InfoController::class, 'services'])->name('services.index');
Route::get('/doctors', [InfoController::class, 'doctors'])->name('doctors.index');