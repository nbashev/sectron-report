<!DOCTYPE html>
<html lang="en">

<head>
    {{-- <meta charset="UTF-8"> --}}
    <base href="{{ url() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Sectron Report</title>

    {{-- Bootstrap Core CSS --}}
    <link type="text/css" media="all" rel="stylesheet" href="{{ public_path('css/bootstrap-cosmo.min.css') }}">

    {{-- bootstrap-table.css --}}
    <link type="text/css" media="all" rel="stylesheet" href="{{ public_path('css/bootstrap-table/bootstrap-table.min.css') }}">


</head>

<body>
	<div id="wrapper">

	   @yield('content')

	   @include('layouts.partials._report-footer-print')

	   @yield('scripts')
	   @yield('styles')
	</div>
</body>

</html>
