<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
    <title>Dashboard | BPSC BCS Statistics</title>
    <meta name="description" content=""/>
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    @include('partials.header')

  </head>

  <body>

    @include('partials.navigation')

    {{ $slot }}

    @include('partials.footer')

  </body>

</html>
