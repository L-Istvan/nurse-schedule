@extends('layouts.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">


<div class="content-wrapper" style="background-color: rgb(237, 242, 248);">
    <div class="box">
        <div class="month">
            <ul>
                <a class="nav-link" data-widget="pushmenu" role="button"><i class="fas fa-bars"></i></a>
              <li>
                    <div class="container-fluid">
                      <div class="d-flex justify-content-center">
                          <a href="#" class="btn btn-m" data-toggle="modal" data-target="#exampleModal" style="border-radius: 1rem;background-color:#3e7eb3;color:white;box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);">
                              <img id="regist" src="/dist/img/addemployee.png" alt="">Új nővér regisztálás
                          </a>
                      </div>
                    </div>
              </li>
            </ul>
        </div>
    </div>


    @if (session('err'))
    <div class="alert alert-danger">
        {{ session('succes') }}
    </div>
@elseif ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif









 </div>

 @endsection

