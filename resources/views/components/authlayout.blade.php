<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> {{ $title }} | NDFProject</title>
  <meta name="author" content="Kostify" />
  <link href="{{ asset('img/favicon.ico') }}" rel="icon">
  <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('css/dash.css') }}" rel="stylesheet">
  @turnstileScripts()
</head> 

<body class="authbody">

{{ $slot }}

</body>

</html>