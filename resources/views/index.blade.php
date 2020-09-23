@php
  $config = [
      'appName' => config('app.name'),
      'locale' => $locale = app()->getLocale(),
      'locales' => config('app.locales'),
      'githubAuth' => config('services.github.client_id'),
  ];

  $polyfills = [
      'Promise',
      'Object.assign',
      'Object.values',
      'Array.prototype.find',
      'Array.prototype.findIndex',
      'Array.prototype.includes',
      'String.prototype.includes',
      'String.prototype.startsWith',
      'String.prototype.endsWith',
  ];
@endphp
  <!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>{{ config('app.name') }}</title>
  <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons' rel="stylesheet">
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
<div id="app"></div>
<script>window.config = @json($config);</script>


<script src="https://cdn.polyfill.io/v2/polyfill.min.js?features={{ implode(',', $polyfills) }}"></script>


<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
