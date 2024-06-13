<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $specialite;
    public $availability;
    public $cin;
    public $email;
    public $phone;

    /**
     * Create a new message instance.
     *
     * @param array $data The data to be included in the email
     * @return void
     */
    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->specialite = $data['specialite'];
        $this->availability = $data['availability'];
        $this->cin = $data['cin'];
        $this->email = $data['email'];
        $this->phone = $data['phone'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Demande de Rendez-vous')
                    ->view('mail.appointment_request');
    }
}
