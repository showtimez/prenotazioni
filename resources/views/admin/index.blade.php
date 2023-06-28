@extends('layouts.app')

@section('content')
<h1 class="text-center py-5">Dashboard</h1>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 ">
            @php
                // Retrieve the value of form_disabled from the database and store it in a variable
                $form_disabled = \App\Models\Setting::where('key', 'form_disabled')->value('value');
            @endphp
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Use the variable in your Blade file --}}
            @if($form_disabled == 1)
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-4 bg-success rounded-4">
                            <label for="form_enabled" class="p-3 fw-bold">Abilita modulo di prenotazione:</label>
                            <input type="radio" id="form_enabled" name="form_status" value="0" aria-label="Abilita modulo di prenotazione">
                        </div>
                    </div>
                </div>
            @else
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-4 bg-danger rounded-4 align-items-center">
                            <label for="form_disabled" class="p-3 fw-bold">Disabilita modulo di prenotazione:</label>
                            <input type="radio" id="form_disabled" name="form_status" value="1" aria-label="Disabilita modulo di prenotazione">
                            @endif
                        </div>
                    </div>
                </div>
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
                            <td>{{ $reservation->user->name}}</td>
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
                                {{-- In your Blade file --}}
                                {{-- In your Blade file --}}
                                <td>

                                        {{-- Show both buttons if the reservation has not been accepted or rejected --}}
                                    <form action="{{ route('reservations.accept', $reservation) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Invia e-mail di conferma</button>
                                    </form>



                                    <form action="{{ route('reservations.reject', $reservation) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Rifiuta</button>
                                        </form>



                                    <form action="{{ route('reservations.reset', $reservation) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-warning">Reset</button>
                                    </form>
                                </td>



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
<script>
    document.querySelectorAll('input[name="form_status"]').forEach(radio => {
        radio.addEventListener('change', event => {
            const formDisabled = event.target.value === '1';
            fetch('/reservations/form/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    form_disabled: formDisabled
                })
            }).then(response => {
                if (response.ok) {
                    // Ricarica la pagina dopo aver inviato la richiesta al controller
                    window.location.reload();
                }
            });
        });
    });

</script>
@endsection
