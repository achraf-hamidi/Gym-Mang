<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="csrf-token" content="{{ csrf_token() }}">
       <title>CLUBI - Logiciel de gestion des clubs de sport</title>
       <link rel="icon" type="image/png" href="{{ asset('/admin/favicon32.png?v=3.0.8')}}">
       <meta property="url" content="https://clubi.com/" />
       <meta property="title" content="CLUBI - Logiciel de gestion des clubs de sport" />
      <meta property="description" content="CLUBI, Une solution de gestion complète de votre club" /> 
      
      <link rel="stylesheet" href="{{ asset('/assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css?v=3.0.8') }}"> 
      <link rel="stylesheet" href="{{ asset('/assets/css/shared/style.css?v=3.0.8') }}">
      <link rel="stylesheet" href="{{ asset('/assets/css/demo_1/style.css?v=3.0.8') }}">  
       </head>
<body>
    <div id="app">
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js?v=3.0.8"></script> 
 
</body>
</html>
