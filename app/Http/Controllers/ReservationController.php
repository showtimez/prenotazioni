<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Notifications\ReservationCreated;
use App\Notifications\ReservationAccepted;
use App\Notifications\ReservationRejected;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            'fascia' => 'required|integer|min:1|max:3',
            'posti' => 'required|integer|min:1',
        ]);

        if (auth()->check()) {
            // Se l'utente è autenticato, utilizza l'ID dell'utente autenticato
            $userId = auth()->id();
        } else {
            // Altrimenti, crea un nuovo utente
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'telephone' => $data['telephone'],
                // Aggiungi un valore per la colonna password
                'password' => Hash::make('your-password'),
            ]);
            $userId = $user->id;
        }

        // Recupera la prenotazione per la data selezionata dall'utente
        $reservation = Reservation::where('data', $data['data'])->first();

        // Se non esiste una prenotazione per la data selezionata dall'utente, creane una nuova
        // if (!$reservation) {
        //     $reservation = new Reservation([
        //         'data' => $data['data'],
        //         'fascia_1' => 40,
        //         'fascia_2' => 40,
        //         'fascia_3' => 40,
        //     ]);
        // }

        // // Sottrai il numero di posti prenotati dal valore della colonna corrispondente alla fascia oraria selezionata dall'utente
        // $fasciaColumn = 'fascia_' . $data['fascia'];
        // $newValue = $reservation->$fasciaColumn - $data['posti'];

        // if ($newValue < -40) {
        //     // Handle the error (e.g., return an error message to the user)
        //     return redirect('/prenota')->with('error', 'I posti per la fascia oraria selezionata sono esauriti.');
        // } else {
        //     $reservation->$fasciaColumn = $newValue;
        // }


        // Salva la prenotazione
        $reservation = Reservation::create([
            'user_id' => $userId,
            'data' => $data['data'],
            'fascia' => $data['fascia'],
            'posti' => $data['posti'],
            'token' => Str::random(64),
        ]);

        if (auth()->check() && auth()->user()->isAdmin()) {
            // Accetta direttamente la prenotazione se l'utente è un amministratore
            $reservation->update(['accepted' => true]);
        } else {
            // Invia la notifica all'admin
            Notification::route('mail', 'admin@example.com')
                ->notify(new ReservationCreated($reservation, $data['fascia'], $data['posti']));
        }

        return redirect('/prenota')->with('status', 'Prenotazione effettuata con successo!');
    }
    public function accept(Reservation $reservation)
    {
        // Aggiorna lo stato della prenotazione
        $reservation->update(['accepted' => true]);

        // Recupera la fascia oraria e il numero di posti prenotati dall'utente
        $fascia = $reservation->fascia;
        $posti = $reservation->posti;

        // Invia la notifica all'utente
        $reservation->user->notify(new ReservationAccepted($reservation, $fascia, $posti));

        return redirect('/reservations')->with('status', 'Prenotazione accettata con successo!');
    }

    public function update(Request $request, Reservation $reservation)
    {
        $data = $request->validate([
            'fascia' => 'required|integer|min:1|max:3',
            'posti' => 'required|integer|min:1',
            'table_id' => 'nullable|integer',
        ]);

        // Aggiorna la prenotazione con i dati modificati dall'amministratore
        $reservation->update($data);

        return redirect()->back()->with('status', 'Prenotazione aggiornata con successo!');
    }

    public function updateTable(Request $request, Reservation $reservation)
{
    $data = $request->validate([
        'table_id' => 'nullable|integer',
    ]);

    // Aggiorna la prenotazione con il tavolo selezionato dall'amministratore
    $reservation->update($data);
}
public function acceptViaEmail($token)
{
    $reservation = Reservation::where('token', $token)->firstOrFail();
    $reservation->update(['is_accepted' => true]);

    return redirect('/')->with('status', 'Prenotazione accettata con successo!');
}

public function rejectViaEmail($token)
{
    $reservation = Reservation::where('token', $token)->firstOrFail();
    $reservation->update(['is_accepted' => false]);

    return redirect('/')->with('status', 'Prenotazione rifiutata con successo!');
}
}
