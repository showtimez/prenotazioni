@extends('layouts.app')

@section('content')
<h1 class="text-center py-5">Dashboard</h1>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 shadow">
            <h2 class="text-center py-3">Prenotazioni</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Fascia oraria</th>
                        <th>Posti</th>
                        <th>Tavolo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservations as $reservation)
                        <tr>
                            <td>{{ $reservation->id }}</td>
                            <td>{{ $reservation->data }}</td>
                            <form action="/reservations/{{ $reservation->id }}/update" method="post">
                                @csrf
                                <td>
                                    <input type="number" name="fascia" value="{{ $reservation->fascia }}" class="form-control">
                                </td>
                                <td>
                                    <input type="number" name="posti" value="{{ $reservation->posti }}" class="form-control">
                                </td>
                                <td>
                                    <select name="table_id" class="form-control">
                                        <option value="">Seleziona un tavolo</option>
                                        @foreach ($tables as $table)
                                            <option value="{{ $table->id }}" @if ($reservation->table_id == $table->id) selected @endif>{{ $table->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-primary">Salva</button>
                                </td>
                            </form>
                            <td>
                                <form action="/reservations/{{ $reservation->id }}/accept" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Accetta</button>
                                </form>
                            </td>
                            <td>
                                <form action="/reservations/{{ $reservation->id }}/reject" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Rifiuta</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>




            </table>
        </div>
    </div>
</div>

<script>
    // Aggiungi il codice JavaScript per inviare una richiesta al controller quando l'amministratore seleziona un tavolo dal menù a tendina
    document.querySelectorAll('.fascia-input, .posti-input').forEach(input => {
    input.addEventListener('change', event => {
        const reservationId = event.target.dataset.reservationId;
        const fascia = document.querySelector(`input[name="fascia"][data-reservation-id="${reservationId}"]`).value;
        const posti = document.querySelector(`input[name="posti"][data-reservation-id="${reservationId}"]`).value;
        const tableId = document.querySelector(`select[name="table_id"][data-reservation-id="${reservationId}"]`).value;

        // Invia una richiesta POST al controller per aggiornare la prenotazione con i dati modificati dall'amministratore
        fetch('/reservations/' + reservationId + '/update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ fascia: fascia, posti: posti, table_id: tableId }),
        });
    });
});


</script>
@endsection
