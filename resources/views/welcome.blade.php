<!DOCTYPE html>
<html dir="@if(session()->get('dir')){{session()->get('dir')}}@else ltr @endif" lang="@if(session()->get('locale')){{session()->get('locale')}}@else fr @endif">
    <head>
        <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="csrf-token" content="{{ csrf_token() }}">
       <title>CLUBI</title>
       <link rel="icon" type="image/png" href="{{ asset('/admin/favicon32.png?v=3.1.9')}}">
       <meta property="url" content="https://clubi.com/" />
       <meta property="title" content="CLUBI - Logiciel de gestion des clubs de sport" />
      <meta property="description" content="CLUBI, Une solution de gestion complète de votre club" /> 

      <link rel="stylesheet" href="{{ asset('/assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css?v=3.1.9') }}"> 
      <link rel="stylesheet" href="{{ asset('/assets/css/shared/style.css?v=3.1.9') }}">
      <link rel="stylesheet" href="{{ asset('/assets/css/demo_1/style.css?v=3.1.9') }}"> 
      <link href="{{ asset('/css/app.css?v=3.1.9') }}" rel="stylesheet">
      <script src="{{ asset('/js/app.js?v=3.1.9') }}" defer></script>
      
      <style type="text/css">
      table.datatables {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
      }
      .datatables th, .datatables td {
        text-align: left;
        padding: 8px;
      }
      .datatables tr:nth-child(even){background-color: #f2f2f2}
      </style>
  </head>
  <body>
      <div class="container-scroller" id="app" >
          @if(Auth::check())
          <main-component :user="{{ Auth::user() }}" ></main-component>
          @elseif(Auth::guard('adherent')->check())
          <main-component :user="{{ Auth::guard('adherent')->user() }}"></main-component> 
          @endif
      </div> 
      <script src="https://code.jquery.com/jquery-3.5.1.js?v=3.1.9"></script> 
      <script>
          window.Laravel = {!! json_encode([
              'csrfToken' => csrf_token(),
           ]) !!};
      </script>
      <script>
        @auth
          window.userPermissions = {!! json_encode(Auth::user()->userPermissions, true) !!};
          window.ListPermissions = {!! json_encode(Auth::user()->listPermissions, true) !!}; 
        @else
          window.userPermissions = [];
        @endauth
      </script>
    </body>
</html>