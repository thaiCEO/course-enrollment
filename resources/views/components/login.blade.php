<!DOCTYPE html>
<html lang="en">
<head>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.4/css/boxicons.min.css">
      <!-- style custom login and register -->
      <link rel="stylesheet" type="text/css" href="{{asset('assets/css/custom_login.css')}}">

</head>
<body>

    <section class="container forms">

            @yield('content')

    </section>


 <!-- style custom login and register -->
 <script src="{{asset('assets/js/custom_js.js')}}"></script>

 <!-- lin CDN jquery  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!-- link sweet alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
