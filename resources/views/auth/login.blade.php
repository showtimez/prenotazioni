@extends('layouts.app')
@section('content')

        <div class="container mt-5">
            <div class="row justify-content-center align-items-center vh-100">
                <div class="col-12 col-md-8">

                    <form class="bg-light p-5 border rounded-1 opacity" action="{{route('login')}}" method="POST">

                        <h1 class="text-center">
                            ACCEDI
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
                        <input type="email" name="email" class="form-control" id="email" value="{{old('email')}}">
                        </div>


                        <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password">
                        </div>



                        <button type="submit" class="btn btn-dark">Accedi</button><br>
                        <a href="{{route('register')}}" class="small fst-italic">Non sei registrato?</a>

                    </form>
                </div>
            </div>
        </div>
@endsection
