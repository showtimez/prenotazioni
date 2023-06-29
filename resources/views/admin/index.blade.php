@extends('layouts.app')

@section('content')
<h1 class="text-center py-5">Prenotazioni</h1>

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
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
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




            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Cliente</th>
                        <th>Fascia oraria</th>
                        <th>Posti</th>
                        <th>Tavolo</th>
                    </tr>
                </thead>
                <tbody>
                    <div class="container">
                        <div class="row justify-content-center py-5">
                            <div class="col-12 col-md-8">

                                <form action="/admin/generate-tables" method="post">
                                    @csrf
                                    <label for="numTavoli">Numero di tavoli:</label>
                                    <input type="number" id="numTavoli" name="numTavoli">

                                    <label for="data">Data:</label>
                                    <input type="date" id="data" name="data" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">


                                    <button type="submit" class="btn rounded bg-warning">Genera tavoli</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <form action="/admin/home" method="get">
                        <label for="data">Data:</label>
                        <select name="data" id="data" class="mx-2">
                            <option value="" >Tutte le date</option>
                            @foreach ($dates as $date)
                                <option value="{{ $date }}" @if (request('data') == $date) selected @endif>{{ $date }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class=" mx-3 rounded">Filtra</button>
                    </form>



                    @foreach ($reservations as $reservation)
                        <tr>
                            <td>{{ $reservation->id }}</td>
                            <td>{{ \Carbon\Carbon::parse($reservation->data)->format('d/m') }}</td>
                            <td>{{ $reservation->user->name}} <br>
                            {{ $reservation->user->email }} <br>
                        {{ $reservation->user->telephone }}</td>
                            <td>
                                <span>
                                @switch($reservation->fascia)
                                    @case(1)
                                        18:00 - 19:00
                                        @break
                                    @case(2)
                                        19:00 - 20:00
                                        @break
                                    @case(3)
                                        20:00 - 21:00
                                        @break
                                    @case(4)
                                        21:00 - 22:00
                                        @break
                                    @case(5)
                                        22:00 - 23:00
                                        @break
                                @endswitch
                                </span>
                            </td>


                            <form action="/reservations/{{ $reservation->id }}/update-table-reservation" method="post">
                                @csrf

                                <td>
                                    <input type="number" name="posti" value="{{ $reservation->posti }}" class="form-control">
                                </td>
                                <td>
                                    <select name="table_id" class="form-control">
                                        <option value="">Seleziona un tavolo</option>
                                        @foreach ($tables as $table)
                                        @if ($table->data == $reservation->data)
                                            <option value="{{ $table->id }}" @if ($reservation->table_id == $table->id) selected @endif>{{ $table->name }}</option>
                                        @endif
                                    @endforeach

                                    </select>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-primary">Salva</button>
                                {{-- In your Blade file --}}
                                {{-- In your Blade file --}}
                                <td>

                                        {{-- Show both buttons if the reservation has not been accepted or rejected --}}
                                        {{-- <form action="{{ route('reservations.accept', $reservation) }}" method="post">
                                            @csrf
                                            <input type="hidden" name="acceptance" value="accept">
                                            <button type="submit" class="btn btn-success">Invia e-mail di conferma</button>
                                        </form> --}}




                                    {{-- <form action="{{ route('reservations.reject', $reservation) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Rifiuta</button>
                                    </form> --}}



                                    {{-- <form action="{{ route('reservations.reset', $reservation) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-warning">Reset</button>
                                    </form> --}}
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
