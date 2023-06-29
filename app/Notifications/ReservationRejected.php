<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class ReservationRejected extends Notification
{
    protected $reservation;
    protected $fascia;
    protected $posti;
    public function __construct($reservation, $fascia, $posti)
    {
        $this->reservation = $reservation;
        $this->fascia = $fascia;
        $this->posti = $posti;
    }
    public function via($notifiable)
    {
        return ['mail'];
    }
    public function toMail($notifiable)
    {
        $timeSlots = [
            1 => '18:00 - 19:00',
            2 => '19:00 - 20:00',
            3 => '20:00 - 21:00',
            4 => '21:00 - 22:00',
            5 => '22:00 - 23:00',
        ];

        // Get the time slot for the reservation
        $timeSlot = $timeSlots[$this->fascia];

        return (new MailMessage)
            ->line('Siamo spiacenti ' . $this->reservation->user->name . ', non abbiamo più posti disponibili.')
            ->line('Data: ' . $this->reservation->data)
            ->line('Fascia oraria: ' . $timeSlot)
            ->line('Numero di posti: ' . $this->posti);
    }
}
