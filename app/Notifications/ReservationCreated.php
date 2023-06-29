<?php

namespace App\Notifications;

use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ReservationCreated extends Notification
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
    public function toMail($notifiable)
{
    $acceptUrl = route('reservations.accept-page', $this->reservation->id);

    return (new MailMessage)
        ->line('È stata effettuata una nuova prenotazione.')
        ->line('Nome: ' . $this->reservation->user->name)
        ->line('Email: ' . $this->reservation->user->email)
        ->line('Telefono: ' . $this->reservation->user->telephone)
        ->line('Data: ' . $this->reservation->data)
        ->line('Fascia oraria: ' . $this->fascia)
        ->line('Numero di posti: ' . $this->posti)
        ->action('Accetta prenotazione', $acceptUrl);
}










    public function via($notifiable)
    {
        return ['mail'];
    }
}
