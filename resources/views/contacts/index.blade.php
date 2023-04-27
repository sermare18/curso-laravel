@extends('layouts.app')

@section('content')
  <div class="container">
    @forelse ($contacts as $contact)
      <div class="d-flex justify-content-between bg-dark mb-3 rounded px-4 py-2">
        <div>
          {{-- Imagen --}}
          <a href="{{ route('contacts.show', $contact->id) }}">
            {{-- Accedemos a storage/app/public para sacar la url que nos permita visualizar en el navegador la imagen del contacto --}}
            {{-- el método route() se usa para generar URLs para rutas con nombre en tu aplicación Laravel. Si lo que quieres es generar la URL para una imagen almacenada en el disco del servidor, deberías usar el método url() de la clase Storage --}}
            <img class="profile_picture" src="{{ Storage::url($contact->profile_picture) }}">
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
    {{-- En contact controller en el método index() que es el que utiliza esta vista hemos añadido el método
    paginate(6), por lo tanto ahora $contacts es un objeto paginador al cual podemos llamar a su método
    links para que nos proporcione el html necesario para moverse entre distintas páginas  de 6 contactos cada una--}}
    {{ $contacts->links() }}
  </div>
@endsection
