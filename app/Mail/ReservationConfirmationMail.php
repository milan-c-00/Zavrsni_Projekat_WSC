<?php

namespace App\Mail;

use App\Http\Resources\ReservationResource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $reservation;
    /**
     * Create a new message instance.
     */
    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }

    public function build(){
        $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Reservation Confirmed')
            ->view('mail.reservation-confirmed', ['reservation' => ReservationResource::make($this->reservation)]);
    }
}
