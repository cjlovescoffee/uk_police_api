<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>UK Police Service</title>
    <meta name="description" content="A data visualisation service for the United Kingdom's Police force API">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/app.css" />
  </head>
  <body>
    <header class="show">
      <div class="container">
        <ul class="nav">
          <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('forces') }}">Forces</a></li>
        </ul>
      </div>
    </header>
    <main class="flex-fill">
      @yield('main')
    </main>
    <footer>
      <div class="container">
        <p>Application designed and developed by Christopher West</p>
      </div>
    </footer>
    <script src="/js/app.js"></script>
  </body>
</html>
