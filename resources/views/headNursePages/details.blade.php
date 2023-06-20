@extends('layouts.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">


<div class="content-wrapper" style="background-color: rgb(237, 242, 248);">
    <div class="row">
        <div class="col-6">
            alma
        </div>
        <div class="col-6">
            korte
        </div>

    </div>


 </div>

 @endsection

