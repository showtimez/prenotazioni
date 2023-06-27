<?php

namespace App\Http\Controllers;
use App\Models\Setting;
use App\Models\Table;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationConfirmation;
class AdminController extends Controller
{

    public function index()
    {
        $reservations = Reservation::all();
        $tables = Table::all();

        return view('admin.index', compact('reservations', 'tables'));
    }


    // In your AdminController


    public function acceptReservation(Reservation $reservation)
    {
        try {
            $acceptance = request()->input('acceptance');

            if ($acceptance == 'accept') {
                // Rimuovi l'aggiornamento del campo is_accepted nel database
                // $reservation->update(['is_accepted' => true]);

                // Invia l'email di conferma al cliente
                Mail::to($reservation->email)->send(new ReservationConfirmation($reservation));

                return redirect()->back()->with('acceptedReservation', 'Prenotazione accettata');
            } elseif ($acceptance == 'reject') {
                // Gestisci il rifiuto della prenotazione
                // ...
            }

        } catch (\Exception $e) {
            // Gestisci l'eccezione qui
            return redirect()->back()->with('error', 'Si è verificato un errore durante l\'accettazione della prenotazione: ' . $e->getMessage());
        }
    }








    public function resetReservation(Reservation $reservation)
    {
        try {
            $reservation->update(['is_accepted' => null]);

            return redirect()->back()->with('nulledReservation', 'Prenotazione da rivedere');
        } catch (\Exception $e) {
            // Gestisci l'eccezione qui
            return redirect()->back()->with('error', 'Si è verificato un errore durante la reimpostazione della prenotazione: ' . $e->getMessage());
        }
    }

    public function rejectReservation(Reservation $reservation)
    {
        try {
            $reservation->update(['is_accepted' => false]);

            return redirect()->back()->with('rejectedReservation', 'Prenotazione rifiutata');
        } catch (\Exception $e) {
            // Gestisci l'eccezione qui
            return redirect()->back()->with('error', 'Si è verificato un errore durante il rifiuto della prenotazione: ' . $e->getMessage());
        }
    }

    public function updateTable(Request $request, Reservation $reservation)
    {
        try {
            // Aggiorna la prenotazione con il tavolo selezionato dall'amministratore
            $reservation->update(['table_id' => $request->input('table_id')]);
        } catch (\Exception $e) {
            // Gestisci l'eccezione qui
            return redirect()->back()->with('error', 'Si è verificato un errore durante l\'aggiornamento del tavolo: ' . $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $formDisabled = $request->input('form_disabled');
            Setting::updateOrCreate(
                ['key' => 'form_disabled'],
                ['value' => $formDisabled]
            );

            return redirect()->back()->with('success', 'Impostazione aggiornata correttamente');
        } catch (\Exception $e) {
            // Gestisci l'eccezione qui
            return redirect()->back()->with('error', 'Si è verificato un errore durante l\'aggiornamento delle impostazioni: ' . $e->getMessage());
        }
    }
}


