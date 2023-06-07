@extends('layouts.app')

@section('content')
    <h1>Prenota</h1>

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

    <form action="/prenota" method="post">
        @csrf

        <div class="form-group">
            <label for="name">Nome</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="telephone">Telefono</label>
            <input type="number" name="telephone" id="telephone" class="form-control @error('telephone') is-invalid @enderror" value="{{ old('telephone') }}">
            @error('telephone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="data">Data</label>
            <input type="date" name="data" id="data" class="form-control @error('data') is-invalid @enderror" value="{{ old('data') }}">
            @error('data')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="fascia">Fascia oraria</label>
            <select name="fascia" id="fascia" class="form-control @error('fascia') is-invalid @enderror">
                <option value="">Seleziona una fascia oraria</option>
                <option value="1" @if (old('fascia') == 1) selected @endif>Fascia 1</option>
                <option value="2" @if (old('fascia') == 2) selected @endif>Fascia 2</option>
                <option value="3" @if (old('fascia') == 3) selected @endif>Fascia 3</option>
                <option value="4" @if (old('fascia') == 4) selected @endif>Fascia 4</option>
            </select>
            @error('fascia')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="posti">Numero di posti</label>
            <input type="number" name="posti" id="posti" class="form-control @error('posti') is-invalid @enderror" value="{{ old('posti') }}">
            @error('posti')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>


        <button type="submit" class="btn btn-primary">Prenota</button>
    </form>
@endsection
