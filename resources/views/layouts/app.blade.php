<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>
  <!-- Crea una pila de scripts la cual se irá rellenando a través de otras vistas -->
  @stack('scripts')

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
  <div id="app">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
      <div class="container">
        <img src="/img/logo.png" class="me-1">
        <a class="navbar-brand" href="{{ url('/') }}">
          {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false"
          aria-label="{{ __('Toggle navigation') }}">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Left Side Of Navbar -->
          <ul class="navbar-nav me-auto">

          </ul>

          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ms-auto">
            <!-- Authentication Links -->
            @guest
              <!-- Si el usuario no esta autentificado -->
              @if (Route::has('login'))
                <li class="nav-item">
                  <a class="nav-link"
                    href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
              @endif

              @if (Route::has('register'))
                <li class="nav-item">
                  <a class="nav-link"
                    href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
              @endif
            @else
              <!-- Si el usuario esta autentificado -->
              <li class="nav-item">
                <a class="nav-link" href="{{ route('contacts.index') }}">My
                  Contacts</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('contacts.create') }}">Create
                  New Contact</a>
              </li>
              <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle"
                  href="#" role="button" data-bs-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false" v-pre>
                  {{ Auth::user()->name }}
                </a>

                <div class="dropdown-menu dropdown-menu-end"
                  aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}"
                    method="POST" class="d-none">
                    @csrf
                  </form>
                </div>
              </li>
            @endguest
          </ul>
        </div>
      </div>
    </nav>

    <main class="py-4">
      {{-- Si no existe alerta el get devuelve null que se convierte en un false en la condición --}}
      @if ($alert = session()->get('alert'))
        {{-- @php
          $type = $alert['type'];
          $message = $alert['message'];
        @endphp --}}
        <x-alert :type="$alert['type']" :message="$alert['message']" />
      @endif

      {{-- Comprobamos si la free trial del usuario ya ha vencido --}}
      {{-- Para que muestre la alerta se deben de dar las condiciones de que no estes subscrito y estes aun en el periodo de prueba --}}
      {{-- El operador ?-> es el operador de fusión de nulos en la llamada a un método. 
      Este operador permite llamar a un método en un objeto si el objeto no es null. Si el objeto es null, 
      la llamada al método se omite y se devuelve null en su lugar. Posteriormente null se evalua a false --}}
      @if (!auth()->user()?->subscribed() && auth()->user()?->onTrial())
        @php
          $freeTrialRemainingDays = now()->diffInDays(auth()->user()->trial_ends_at);
        @endphp
        <x-alert type="info" message="Trial ends in {{ $freeTrialRemainingDays }} days. Upgrade <a href={{ route('checkout') }}>here</a>" />
      @endif

      @yield('content')
    </main>
  </div>
</body>

</html>
