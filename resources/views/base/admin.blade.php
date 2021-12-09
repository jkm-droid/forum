<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script>document.getElementsByTagName("html")[0].className += " js";</script>
    <link rel="stylesheet" href="{{ asset('admin-assets/css/style.css') }}">
    <title>Responsive Sidebar Navigation | CodyHouse</title>
</head>
<body>
<!--header-->
@include('admin_partials.header')
<!--end header-->

<!--main content-->
<main class="cd-main-content" style="">

<!--side menu-->
@include('admin_partials.side_menu')
<!--end side menu-->

    @yield('content')

</main>
<!-- end main-content -->

<!--footer-->
<!--end footer-->
<script src="{{ asset('admin-assets/js/util.js') }}"></script> <!-- util functions included in the CodyHouse framework -->
<script src="{{ asset('admin-assets/js/menu-aim.js') }}"></script>
<script src="{{ asset('admin-assets/js/main.js') }}"></script>
<!--Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
