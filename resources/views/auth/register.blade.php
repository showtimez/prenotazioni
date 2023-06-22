@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-12 col-md-8">

            <form class="bg-light p-5 border rounded-1 opacity" action="{{route('register')}}" method="POST">

                <h1 class="text-blackcustom text-center">
                    REGISTRATI
                </h1>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @csrf

                <div class="mb-3">
                  <label for="email" class="form-label">Indirizzo Email</label>
                  <input type="email" name="email" class="form-control" id="email" placeholder="example@gmail.com">
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Nome Utente</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="min.3 max.10">
                  </div>

                  <div class="mb-3">
                    <label for="telephone" class="form-label">Numero di telefono</label>
                    <input type="number" name="telephone" class="form-control" id="telephone" >
                  </div>

                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" name="password" class="form-control" id="password" placeholder="min.8 ">
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Conferma Password</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="min.8">
                  </div>


                <button type="submit" class="btn back">Registrati</button><br>
                <a href="{{route('login')}}" class="small fst-italic">Sei già registrato?</a>

            </form>
        </div>
    </div>
</div>


@endsection
