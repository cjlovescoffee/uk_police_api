<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>UK Police Service</title>
    <meta name="description" content="A data visualisation service for the United Kingdom's Police force API">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>
    <header>
    </header>
    <main>
      @yield('main')
    </main>
    <footer>
    </footer>
  </body>
</html>
