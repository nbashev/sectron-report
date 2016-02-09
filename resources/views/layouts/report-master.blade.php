<!DOCTYPE html>
<html lang="en">

<head>
    {{-- <meta charset="UTF-8"> --}}
    <base href="{{ url() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Sectron Report</title>

    {{-- Bootstrap Core CSS --}}
    <link href=" {{ URL::asset('css/bootstrap-cosmo.min.css') }}" rel="stylesheet">

    {{-- Custom google fonts --}}
    <link href="{{ URL::asset('css/bootstrap-cosmo-fonts.css') }}" rel="stylesheet">

    {{-- bootstrap-table.css --}}
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap-table/bootstrap-table.min.css') }}">


</head>

<body>
	<div id="wrapper">

	   @yield('content')

	   @include('layouts.partials._report-footer')

	   @yield('scripts')
	   @yield('styles')
	</div>
</body>

</html>
