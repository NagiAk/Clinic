<?php

namespace App\Http\Controllers;

use App\Mail\errorMail;
use App\Mail\rdvMail;
use App\Models\Email;
use App\Models\EmailSent;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\RDV;
use App\Models\Schedule;
use App\Models\Specialite;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;


class ValidationController extends Controller
{
    public function processValidation(Request $request)
    {
        $validatedEmails = $request->input('validated_emails', []);
        $currentDate = Carbon::now()->format('Y-m-d');

        // Process the validation for each selected email
        foreach ($validatedEmails as $info) {
            $infoArray = explode(', ', $info);
            $sender = $infoArray[0];
            $emailId = str_replace(',', '',  $infoArray[1]);
            
            // Define patterns for each element of the array
            $namePattern = '/^[A-Za-zÀ-ÖØ-öø-ÿ\-\' ]+$/u'; // Matches letters, spaces, and certain special characters in names
            $emailPattern = '/^\S+@\S+\.\S+$/'; // Matches a valid email address
            $cinPattern = '/^[A-Za-z](?=.{7}$)\d{7}|[A-Za-z]{2}(?=.{6}$)\d{6}$/';
            $datePattern = '/^\d{4}-\d{2}-\d{2}$/'; // Matches a date in YYYY-MM-DD format
            $phonePattern = '/^\d{10}$/'; // Matches a 10-digit phone number
            
            if (count($infoArray) == 8 &&
                preg_match($namePattern, $infoArray[2]) &&
                preg_match($emailPattern, $infoArray[6]) &&
                preg_match($cinPattern, $infoArray[5]) &&
                preg_match($datePattern, $infoArray[4]) &&
                preg_match($phonePattern, $infoArray[7]) && 
                $infoArray[3] > $currentDate) {
                
                $specialite = Specialite::where('nom', $infoArray[3])->first();
                if ($specialite) {
                    $nomP = explode(' ', $infoArray[2]);

                    $patient = Patient::where('cin', $infoArray[5])->first();
                    
                    if (!$patient) {
                        $patient = new Patient();
                        $patient->nom = $nomP[1];
                        $patient->prenom = $nomP[0];
                        $patient->cin = $infoArray[5];
                        $patient->email = $infoArray[6];
                        $patient->phone = $infoArray[7];
                        $patient->save();
                    }

                    $rdvDate = Carbon::parse($infoArray[4]);

                    // Check if the rdvDate is older than tomorrow
                    if ($rdvDate->lessThanOrEqualTo(Carbon::now()->addDay())) {
                        $rdvDate = Carbon::now()->addDays(2);
                    }

                    $schedule = null;
                    $medecin = null;

                    // First, check each doctor for the requested date
                    foreach ($specialite->medecins as $doctor) {
                        $schedule = $this->findFirstAvailableSchedule($doctor, $rdvDate);
                        if ($schedule) {
                            $medecin = $doctor;
                            break;
                        }
                    }

                    // If no schedule is found on the requested date, extend the search up to one week
                    if (!$schedule) {
                        $endDate = $rdvDate->copy()->addWeek();
                        $date = $rdvDate->copy();

                        while ($date <= $endDate && !$schedule) {
                            foreach ($specialite->medecins as $doctor) {
                                $schedule = $this->findFirstAvailableSchedule($doctor, $date);
                                if ($schedule) {
                                    $medecin = $doctor;
                                    break 2; // Break both loops if a schedule is found
                                }
                            }
                            $date->addDay();
                        }
                    }
                    if ($schedule && $medecin) {
                        $rdv = new RDV();
                        $rdv->patient_id = $patient->id;
                        $rdv->medecin_id = $medecin->id;
                        $rdv->schedule_id = $schedule->id; 
                        $rdv->save();

                        $schedule->status = 'booked';
                        $schedule->save();

                        Mail::to($infoArray[6])->send(new RdvMail($schedule->date . ' at ' . $schedule->time, $infoArray[2]));

                        Email::where('id', $emailId)->update(['validated' => true]);

                        $emailContent = $this->getEmailContent($infoArray[2], $schedule->date . ' at ' . $schedule->time);
                        $msgSent = new EmailSent();
                        $msgSent->email_id = $emailId;
                        $msgSent->reciever = $infoArray[6];
                        $msgSent->subject = 'Rendez-vous Confirmation';
                        $msgSent->body = $emailContent;
                        $msgSent->sent_date = $currentDate;
                        $msgSent->save();
                    } else {
                        Mail::to($sender)->send(new ErrorMail());

                        $emailContent = $this->getErrorEmailContent();
                        $msgSent = new EmailSent();
                        $msgSent->email_id = $emailId;
                        $msgSent->reciever = $sender;
                        $msgSent->subject = 'Rendez-vous Error';
                        $msgSent->body = $emailContent;
                        $msgSent->sent_date = $currentDate;
                        $msgSent->save();

                        Email::where('id', $emailId)->update(['validated' => true]);
                    }
                }
            }
        }

        return redirect()->route('emails.index');
    }

    private function findFirstAvailableSchedule($medecin, $date)
    {
        $schedules = Schedule::where('medecin_id', $medecin->id)
            ->where('date', $date->format('Y-m-d'))
            ->where('status', 'available')
            ->orderBy('time')
            ->get();

        return $schedules->first();
    }

    private function getEmailContent($fullname, $date)
    {
        // Load the view and render it to get the HTML content
        $htmlContent = view('mail.reponse', [
            'fullname' => $fullname,
            'date' => $date,
        ])->render();

        $textContent = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '', $htmlContent); // Remove <style> tags
        $textContent = strip_tags($textContent); // Remove all HTML tags

        return $textContent;
    }
    private function getErrorEmailContent()
    {
        // Load the view and render it to get the HTML content
        $htmlContent = view('mail.error')->render();

        $textContent = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '', $htmlContent); // Remove <style> tags
        $textContent = strip_tags($textContent); // Remove all HTML tags

        return $textContent;
    }
}

