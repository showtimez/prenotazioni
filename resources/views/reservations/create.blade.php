@extends('layouts.app')

@section('content')
    @if ($form_disabled)
        <h1 class="text-center py-5">Il modulo di prenotazione è stato disabilitato dall'amministratore</h1>
    @else
    <h1 class="text-center py-5">Prenota il tuo tavolo</h1>

    @if (session('status'))
        <div class="alert alert-success text-center">
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<div class="container ">
    <div class="row justify-content-center rounded shadow">
        <div class="col-md ">

            <form action="/prenota/store" method="post">
                @csrf

                <div class="form-group text-center mb-3">
                    <label for="name">Nome</label>
                    <div class="row">
                    <div class="col-md-8 offset-md-2">
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                </div>
            </div>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group text-center mb-3">
                    <label for="email">Email</label>
                    <div class="row">
                      <div class="col-md-8 offset-md-2">
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                      </div>
                    </div>
                    @error('email')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>


                <div class="form-group text-center mb-3">
                    <label for="telephone">Telefono</label>
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                    <input type="number" name="telephone" id="telephone" class="form-control @error('telephone') is-invalid @enderror" value="{{ old('telephone') }}">
                </div>
            </div>
                    @error('telephone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                </div>
<div class="col-md">
    <div class="form-group text-center mb-3">
        <label for="data">Data</label>
        <div class="row justify-content-center">
            <div class="col-auto">
        <input type="date" name="data" id="data" class="form-control @error('data') is-invalid @enderror" value="{{ old('data') }}">
    </div>
</div>
        @error('data')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>


      <div class="form-group text-center mb-3">
        <label for="fascia">Fascia oraria</label>
        <div class="form-check">
            <div class="row justify-content-center">
                <div class="col-auto">
                    <input class="form-check-input" type="radio" name="fascia" id="fascia1" value="1">
                    <label class="form-check-label" for="fascia1">18.00 - 19.00</label>
                </div>
            </div>
        </div>

        <div class="form-check">
            <div class="row justify-content-center">
                <div class="col-auto">
                    <input class="form-check-input" type="radio" name="fascia" id="fascia2" value="2">
                    <label class="form-check-label" for="fascia2">19.00 - 20.00</label>
                </div>
            </div>
        </div>

        <div class="form-check">
            <div class="row justify-content-center">
                <div class="col-auto">
                    <input class="form-check-input" type="radio" name="fascia" id="fascia3" value="3">
                    <label class="form-check-label" for="fascia3">20.00 - 21.00</label>
                </div>
            </div>
        </div>

        <div class="form-check">
            <div class="row justify-content-center">
                <div class="col-auto">
                    <input class="form-check-input" type="radio" name="fascia" id="fascia4" value="4">
                    <label class="form-check-label" for="fascia4">21.00 - 22.00</label>
                </div>
            </div>
        </div>

        <div class="form-check">
            <div class="row justify-content-center">
                <div class="col-auto">
                    <input class="form-check-input" type="radio" name="fascia" id="fascia5" value="5">
                    <label class="form-check-label" for="fascia5">22.00 - 23.00</label>
                </div>
            </div>
        </div>

        @error('fascia')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>





                <div class="form-group text-center mb-3">
                    <label for="posti">Numero di posti</label>
                    <div class="row justify-content-center">
                        <div class="col-auto">
                    <select name="posti" id="posti" class="form-control @error('posti') is-invalid @enderror">
                        <option value="">Seleziona il numero di posti</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16+</option>
                      </select>
                </div>
                  </div>
    </div>

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
</div>
<script>
    // Get the current date
    let today = new Date();

    // Format the date as yyyy-mm-dd
    let formattedDate = today.getFullYear() + '-' + (today.getMonth() + 1).toString().padStart(2, '0') + '-' + today.getDate().toString().padStart(2, '0');

    // Set the value of the date input to the current date
    document.getElementById('data').value = formattedDate;
  </script>
  <script>
    // Get all the checkbox inputs
    let checkboxes = document.querySelectorAll('input[type=checkbox][name^=fascia]');

    // Add an event listener to each checkbox
    checkboxes.forEach(function(checkbox) {
      checkbox.addEventListener('change', function() {
        // Count the number of checked checkboxes
        let checkedCount = document.querySelectorAll('input[type=checkbox][name^=fascia]:checked').length;

        // If two or more checkboxes are checked
        if (checkedCount >= 1) {
          // Disable all unchecked checkboxes
          checkboxes.forEach(function(checkbox) {
            if (!checkbox.checked) {
              checkbox.disabled = true;
            }
          });
        } else {
          // Enable all checkboxes
          checkboxes.forEach(function(checkbox) {
            checkbox.disabled = false;
          });
        }
      });
    });
  </script>
@endif

@endsection
