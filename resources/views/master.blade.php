<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('FED_NAME') }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('css/jquery-ui.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('css/fed.css') }}">
    <style>
        /* control body background */
        body {
            background-color: #{{ $style->primary1 }};
        }
        /* control navbar background */
        .navbar-default {
            background: linear-gradient(#{{ $style->secondary2 }}, #{{ $style->primary2 }});
            border: 0;
            border-radius: 0;
        }
        /* control top menu and admin menu link colors */
        .navbar-default .navbar-nav > li > a:link,a:visited,
        .navbar-default .navbar-nav > li > a,
        .dropdown-menu > li > a {
            color: #{{ $style->secondary1 }};
        }
        .navbar-default .navbar-nav > li > a:hover,a:focus,
        .navbar-default .navbar-nav > .open > a,
        .navbar-default .navbar-nav > .open > a:hover,
        .navbar-default .navbar-nav > .open > a:focus {
            color: #{{ $style->secondary1 }};
        }
        .dropdown-menu > li > a:hover,
        .dropdown-menu > li > a:focus {
            background-color: #{{ $style->secondary3 }};
        }
        .dropdown-menu {
            background-color: #{{ $style->primary2 }};
            border-color: #{{ $style->primary2 }};
        }
        /* control text color, badge color */
        body,
        .hovereffectChamp h2,
        .hovereffectChamp p,
        .badge {
            color: #{{ $style->secondary1 }};
        }
        /* control link color */
        a:link,
        a:visited,
        .hovereffect a{
            color: #{{ $style->secondary1 }};
        }
        /* control table striped row background color */
        .table-striped > tbody > tr:nth-of-type(odd) {
            background-color: #{{ $style->secondary3 }};
        }
        /* control table border, hr tags, admin applications badge background color, help-block */
        .table > thead > tr > th,
        .table > tbody > tr > td,
        .page-header,
        .hovereffect .overlay {
            border-color: #{{ $style->secondary4 }};
        }
        .hovereffectChamp h2:after,
        .badge {
            background-color: #{{ $style->secondary4 }};
        }
        .help-block {
            color: #{{ $style->secondary4 }};
        }
        /* control champions container and forum breadcrumb */
        .hovereffectChamp,
        .breadcrumb {
            background-color: #{{ $style->secondary2 }};
        }
        /* control admin tab hover */
        .nav-tabs > li > a:hover,
        .nav-tabs > li > a:focus {
            text-decoration: none;
            background-color: #{{ $style->secondary3 }};
            border-color: #{{ $style->secondary2 }};
        }
        /* control admin tab */
        .nav-tabs > li > a {
            background-color: #{{ $style->primary2 }};
            border-color: #{{ $style->secondary2 }};
        }
        /* control admin tab active */
        .nav-tabs > li.active > a,
        .nav-tabs > li.active > a:hover,
        .nav-tabs > li.active > a:focus  {
            background-color: #{{ $style->primary1 }};
            border-color: #{{ $style->secondary2 }};
            color: #{{ $style->secondary1 }};
        }
        .nav-tabs {
            border-bottom-color: #{{ $style->secondary2 }};
        }
        /* control forum breadcrumb text color */
        .breadcrumb > li + li:before {
            color: #{{ $style->secondary1 }};
        }
        /* control forum breadcrumb active color */
        .breadcrumb > .active {
            color: {{ $style->secondary2 }};
        }
        /* control forum quote background color and border */
        .quote-container {
            background-color: #{{ $style->secondary2 }};
            border-color: #{{ $style->secondary2 }};
        }
    </style>
</head>
<body>
@include('menu')
<div class="container">
    @if (Session::has('message'))
        <div class="alert alert-success">{{ Session::get('message') }}</div>
    @endif
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @yield('content')
</div>
<script src="{{ url('js/jquery.min.js') }}"></script>
<script src="{{ url('js/bootstrap.min.js') }}"></script>
<script src="{{ url('js/jquery-ui.min.js') }}"></script>
<script src="{{ url('js/sortable.js') }}"></script>
@yield('scripts')
</body>
</html>