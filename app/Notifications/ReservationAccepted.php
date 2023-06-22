<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ReservationAccepted extends Notification
{
    protected $reservation;
    protected $fascia;
    protected $posti;

    public function __construct($reservation, $fascia, $posti)
    {
        $this->reservation = $reservation;
        $this->fascia = $fascia;
        $this->posti = $posti ;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('La tua prenotazione è stata accettata!')
            ->line('Data: ' . $this->reservation->data)
            ->line('Fascia oraria: ' . $this->fascia)
            ->line('Numero di posti: ' . $this->posti);
    }
}
