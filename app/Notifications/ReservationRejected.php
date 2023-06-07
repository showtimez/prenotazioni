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
        return (new MailMessage)
            ->line('Siamo spiacenti, ma la tua prenotazione è stata rifiutata.')
            ->line('Data: ' . $this->reservation->data)
            ->line('Fascia oraria: ' . $this->fascia)
            ->line('Numero di posti: ' . $this->posti);
    }
}
