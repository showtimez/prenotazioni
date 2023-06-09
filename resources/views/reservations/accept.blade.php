@extends('layouts.app')

@section('content')
    <h1>Accetta prenotazione</h1>

    <p>Vuoi accettare questa prenotazione?</p>

    <form action="{{ route('reservations.accept', $reservation->id) }}" method="POST">
        @csrf
        <button type="submit">Accetta</button>
    </form>
    <form action="{{ route('reservations.reject', $reservation->id) }}" method="POST">
        @csrf
        <button type="submit">Rifiuta</button>
    </form>
@endsection
