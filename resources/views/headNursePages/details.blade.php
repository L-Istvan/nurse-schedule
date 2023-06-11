@extends('layouts.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">



<div class="content-wrapper">
    {{-- ezt majd mobilra vagy tabletra
    <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button">
            <i class="fas fa-bars"></i>
          </a>
        </li>
    </ul>
    --}}



    <div class="box">
        <div class="month">
            <ul>
              <li class="left"> <a class="nav-link" data-widget="pushmenu" role="button"><i class="fas fa-bars"></i></a></li>
              <li>
                <label id="month"></label><br>
                <span id="year" style="font-size:18px"></span>
              </li>
            </ul>
        </div>
    </div>


    <div class="row container">
        <div class="col-1 d-none d-xl-block">
        </div>
        <div class="ml-4 col-12 col-xl-7">
            bvcbvc
        </div>
        <div class="col-4 d-none d-xl-block">
        </div>
    </div>


</div>

<script src="js/HeadNursePages/setting.js"></script>
@endsection
