@extends('layouts.app')

@section('content')
    @if ($form_disabled)
        <h1 class="text-center py-5">Il modulo di prenotazione è stato disabilitato dall'amministratore</h1>
    @else
    <h1 class="text-center py-5">Prenota il tuo tavolo</h1>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<div class="container ">
    <div class="row justify-content-center">
        <div class="col-12 col-md-4 shadow">

            <form action="/prenota" method="post">
                @csrf

                <div class="form-group text-center mb-3">
                    <label for="name">Nome</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group text-center mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group text-center mb-3">
                    <label for="telephone">Telefono</label>
                    <input type="number" name="telephone" id="telephone" class="form-control @error('telephone') is-invalid @enderror" value="{{ old('telephone') }}">
                    @error('telephone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group text-center mb-3">
                    <label for="data">Data</label>
                    <input type="date" name="data" id="data" class="form-control @error('data') is-invalid @enderror" value="{{ old('data') }}">
                    @error('data')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group text-center mb-3">
                    <label for="fascia">Fascia oraria</label>
                    <select name="fascia" id="fascia" class="form-control @error('fascia') is-invalid @enderror">
                        <option value="">Seleziona una fascia oraria</option>
                        <option value="1" @if (old('fascia') == 1) selected @endif>18.30 - 20.00</option>
                        <option value="2" @if (old('fascia') == 2) selected @endif>20.00 - 21.30</option>
                        <option value="3" @if (old('fascia') == 3) selected @endif>21.30 - 23.00</option>
                    </select>
                    @error('fascia')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group text-center mb-3">
                    <label for="posti">Numero di posti</label>
                    <input type="number" name="posti" id="posti" class="form-control @error('posti') is-invalid @enderror" value="{{ old('posti') }}">
                    @error('posti')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="text-center py-3">
                    <button type="submit" class="btn btn-primary">Prenota</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
