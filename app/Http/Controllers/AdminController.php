<?php

namespace App\Http\Controllers;
use App\Models\Table;
use App\Models\Reservation;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index(){
        $reservations = Reservation::all();
        $tables = Table::all();
        $reservation_to_check = Reservation::where('is_accepted', null)->get();
        $reservation_to_check_ok = Reservation::where('is_accepted', true)->get();
        $reservation_to_check_ko = Reservation::where('is_accepted', false)->get();
        return view ('admin.index', compact('reservations', 'tables', 'reservation_to_check', 'reservation_to_check_ok', 'reservation_to_check_ko'));
    }



    public function acceptReservation(Reservation $reservation){
        $reservation->setAccepted(true);
        return redirect()->back()->with('acceptedReservation', 'Prenotazione accettata');
    }

    public function nullReservation(Reservation $reservation){
        $reservation->setAccepted(null);
        return redirect()->back()->with('nulledReservation', 'Prenotazione da rivedere');
    }

    public function rejectReservation(Reservation $reservation){
        $reservation->setAccepted(false);
        return redirect()->back()->with('RejectedReservation', 'Prenotazione rifiutata');
    }

    public function updateTable(Request $request, Reservation $reservation)
    {
        // Aggiorna la prenotazione con il tavolo selezionato dall'amministratore
        $reservation->update(['table_id' => $request->input('table_id')]);
    }
}
