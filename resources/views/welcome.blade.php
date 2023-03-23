@extends('layouts.app')

{{-- Metemos en la pila de la ventana maestra (app.blade) el script que únicamente vamos a utilizar en esta ventana de welcome --}}
@push('scripts')
<script src="{{ asset('js/welcome.js') }}" defer></script>
@endpush

@section('content')
  <div class="welcome d-flex align-items-center justify-content-center">
    <div class="text-center">
      <h1>Store Your Contacts Now</h1>
      <a class="btn btn-lg btn-dark" href="register.php">Get Started</a>
    </div>
  </div>
@endsection
