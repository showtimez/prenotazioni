<?php

namespace App\Http\Controllers;
use App\Models\Table;
use App\Models\Setting;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\TableGeneration;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationConfirmation;

class AdminController extends Controller
{


    public function index(Request $request)
    {
        $dates = Reservation::distinct()->pluck('data');

        $data = $request->input('data');
        if ($data) {
            $reservations = Reservation::where('data', $data)->get();
        } else {
            $reservations = Reservation::all();
        }
        $tables = Table::all();

        return view('admin.index', compact('reservations', 'tables', 'dates'));
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
    public function storeTables(Request $request)
{
    $numTavoli = $request->input('numTavoli');
    $data = $request->input('data');
    $this->generateTables($numTavoli, $data);

    // Reindirizza l'utente alla pagina admin/home
    return redirect('/admin/home');
}



    public function generateTables($numTavoli, $data)
    {
        Table::where('data', $data)->delete();

        for ($i = 1; $i <= $numTavoli; $i++) {
            Table::create([
                'name' => 'Tavolo ' . $i,
                'data' => $data,
                // Aggiungi altre colonne per memorizzare ulteriori dettagli sui tavoli
            ]);
        }

        // Salva il numero di tavoli generati nella tabella TableGeneration
        TableGeneration::create([
            'data' => $data,
            'num_tavoli' => $numTavoli,
        ]);
    }

    public function updateTable(Request $request, Reservation $reservation)
    {
        try {
            // Aggiorna la prenotazione con il tavolo e i posti selezionati dall'amministratore
            $reservation->update([
                'table_id' => $request->input('table_id'),
                'posti' => $request->input('posti')
            ]);

            // Redirect the user to the desired page with a success message
            return redirect('/admin/home')->with('status', 'Prenotazione aggiornata con successo!');
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
