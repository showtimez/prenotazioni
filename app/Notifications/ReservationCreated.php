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
    $acceptUrl = url('/reservations/' . $this->reservation->id . '/accept');
    $rejectUrl = url('/reservations/' . $this->reservation->id . '/reject');

    return (new MailMessage)
        ->line('È stata effettuata una nuova prenotazione.')
        ->line('Nome: ' . $this->reservation->user->name)
        ->line('Email: ' . $this->reservation->user->email)
        ->line('Telefono: ' . $this->reservation->user->telephone)
        ->line('Data: ' . $this->reservation->data)
        ->line('Fascia oraria: ' . $this->fascia)
        ->line('Numero di posti: ' . $this->posti)
        ->line(new HtmlString('<form action="' . $acceptUrl . '" method="POST">' . csrf_field() . '<button type="submit">Accetta</button></form>'))
        ->line(new HtmlString('<form action="' . $rejectUrl . '" method="POST">' . csrf_field() . '<button type="submit">Rifiuta</button></form>'));
}





    public function via($notifiable)
    {
        return ['mail'];
    }
}
