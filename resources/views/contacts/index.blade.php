@extends('layouts.app')

@section('content')
  <div class="container">
    @forelse ($contacts as $contact)
      <div class="d-flex justify-content-between bg-dark mb-3 rounded px-4 py-2">
        <div>
          {{-- Imagen --}}
          <a href="{{ route('contacts.show', $contact->id) }}">
            <img src="/img/logo.png" style="width: 20px;">
          </a>
        </div>
        <div class="d-flex align-items-center">
          {{-- Información --}}
          <p class="me-2 mb-0">{{ $contact->name }}</p>
          <p class="me-2 mb-0 d-none d-md-block"> {{-- Diseño responsive: d-none (Displey none), por defecto no se ve a no ser que el display sea mayor o gual que d-md-block --}}
            <a href="mailto:{{ $contact->email }}">
              {{ $contact->email }}
            </a>
          </p>
          <p class="me-2 mb-0 d-none d-md-block">
            <a href="tel:{{ $contact->phone_number }}">
              {{ $contact->phone_number }}
            </a>
          </p>

          <a class="btn btn-secondary mb-0 me-2 p-1 px-2"
            href="{{ route('contacts.edit', $contact->id) }}">
            {{-- Renderizamos el componente Icon, pasando al constructor el tipo de Icon --}}
            <x-icon icon="pencil" />
          </a>
          {{-- En Laravel, para eliminar un recurso como un contacto, se utiliza el método DELETE
          del protocolo HTTP. Sin embargo, los enlaces <a> solo pueden enviar solicitudes GET. 
          Por lo tanto, para enviar una solicitud DELETE, debes usar un formulario con un método POST
          y un campo oculto _method con el valor DELETE. --}}
          <form action="{{ route('contacts.destroy', $contact->id) }}"
            method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger mb-0 me-2 p-1 px-2">
              {{-- Renderizamos el componente Icon, pasando al constructor el tipo de Icon --}}
              <x-icon icon="trash" />
            </button>
          </form>
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
