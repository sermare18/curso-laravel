@extends('layouts.app')

@section('content')
  {{-- <div class="container pt-4 p-3">
    <div class="row">

      @if ($contacts->count() == 0)
        <div class="col-md-4 mx-auto">
          <div class="card card-body text-center">
            <p>No contacts saved yet</p>
            <a href="./add.php">Add one!</a>
          </div>
        </div>
      @else
        @foreach ($contacts as $contact)
          <div class="col-md-4 mb-3">
            <div class="card text-center">
              <div class="card-body">
                <h3 class="card-title text-capitalize">{{ $contact->name }}</h3>
                <p class="m-2">{{ $contact->phone_number }}</p>
                <a href="" class="btn btn-secondary mb-2">Edit Contact</a>
                <a href="" class="btn btn-danger mb-2">Delete Contact</a>
              </div>
            </div>
          </div>
        @endforeach
      @endif
    </div> --}}

  {{-- Otra forma --}}

  <div class="container pt-4 p-3">
    <div class="row">

      @forelse ($contacts as $contact)
        <div class="col-md-4 mb-3">
          <div class="card text-center">
            <div class="card-body">
              <div class="d-flex justify-content-center mb-2">
                {{-- Accedemos a storage/app/public para sacar la url que nos permita visualizar en el navegador la imagen del contacto --}}
                {{-- el método route() se usa para generar URLs para rutas con nombre en tu aplicación Laravel. Si lo que quieres es generar la URL para una imagen almacenada en el disco del servidor, deberías usar el método url() de la clase Storage --}}
                <a href="{{ route('contacts.show', $contact->id) }}">
                  <img class="profile_picture"
                    src="{{ Storage::url($contact->profile_picture) }}">
                </a>
              </div>
              <a class="text-decoration-none text-white"
                href="{{ route('contacts.show', $contact->id) }}">
                <h3 class="card-title text-capitalize">{{ $contact->name }}</h3>
              </a>
              <p class="m-2">{{ $contact->phone_number }}</p>
              <a href="{{ route('contacts.edit', $contact->id) }}"
                class="btn btn-secondary mb-2">Edit Contact</a>
              <form action="{{ route('contacts.destroy', $contact->id) }}"
                method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger mb-2">Delete
                  Contact</button>
              </form>
            </div>
          </div>
        </div>
      @empty
        <div class="col-md-4 mx-auto">
          <div class="card card-body text-center">
            <p>No contacts saved yet</p>
            <a href="{{ route('contacts.create') }}">Add one!</a>
          </div>
        </div>
      @endforelse
    </div>
  @endsection
