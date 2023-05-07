@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Create New API Token</div>

          <div class="card-body">
            <form method="POST" action="{{ route('tokens.store') }}">
              {{-- esto especifica la URL a la que se enviará el formulario cuando se envíe. En este caso, se utiliza la función route de Laravel para generar la URL a partir de un nombre de ruta. El nombre de ruta utilizado es 'tokens.store', lo que significa que el formulario se enviará a la ruta definida en la función store del controlador TokenController. --}}
              @csrf
              <div class="row mb-3">
                <label for="name"
                  class="col-md-4 col-form-label text-md-end">Name</label>

                <div class="col-md-6">
                  <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                    name="name" value="{{ old('name') }}" autocomplete="name" autofocus>

                    @error('name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
              </div>

              <div class="row mb-0">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                    Submit
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
