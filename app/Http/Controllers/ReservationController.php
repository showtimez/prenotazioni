<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Notifications\ReservationCreated;
use App\Notifications\ReservationAccepted;
use App\Notifications\ReservationRejected;
use Illuminate\Support\Facades\Notification;

class ReservationController extends Controller
{
    public function create()
    {
        return view('reservations.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'telephone' => 'required',
            'data' => 'required|date',
            'fascia' => 'required|integer|min:1|max:4',
            'posti' => 'required|integer|min:1',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'telephone' => $data['telephone'],
        ]);

        // Recupera la prenotazione per la data selezionata dall'utente
        $reservation = Reservation::where('data', $data['data'])->first();

        // Se non esiste una prenotazione per la data selezionata dall'utente, creane una nuova
        if (!$reservation) {
            $reservation = new Reservation(['data' => $data['data']]);
        }

        // Sottrai il numero di posti prenotati dal valore della colonna corrispondente alla fascia oraria selezionata dall'utente
        $fasciaColumn = 'fascia_' . $data['fascia'];
        $newValue = $reservation->$fasciaColumn - $data['posti'];

        if ($newValue < -40) {
            // Handle the error (e.g., return an error message to the user)
            return redirect('/prenota')->with('error', 'I posti per la fascia oraria selezionata sono esauriti.');
        } else {
            $reservation->$fasciaColumn = $newValue;
        }


        // Salva la prenotazione
        $user->reservations()->save($reservation);

        // Invia la notifica all'admin
        Notification::route('mail', 'admin@example.com')
            ->notify(new ReservationCreated($reservation, $data['fascia'], $data['posti']));

        return redirect('/prenota')->with('status', 'Prenotazione effettuata con successo!');
    }
    public function accept(Reservation $reservation)
    {
        // Aggiorna lo stato della prenotazione
        $reservation->update(['accepted' => true]);

        // Calcola la fascia oraria e il numero di posti prenotati dall'utente
        $fascia = 0;
        $posti = 0;
        for ($i = 1; $i <= 4; $i++) {
            if ($reservation->{'fascia_' . $i} < 40) {
                $fascia = $i;
                $posti = 40 - $reservation->{'fascia_' . $i};
                break;
            }
        }

        // Invia la notifica all'utente
        $reservation->user->notify(new ReservationAccepted($reservation, $fascia, $posti));

        return redirect('/reservations')->with('status', 'Prenotazione accettata con successo!');
    }
}
