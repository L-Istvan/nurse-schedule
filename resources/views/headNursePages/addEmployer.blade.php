@extends('layouts.app')
@section('content')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js'></script>
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="content-wrapper">
    <div class="box">
        <div class="month">
            <ul>
              <li class="left"> <a class="nav-link" data-widget="pushmenu" role="button"><i class="fas fa-bars"></i></a></li>
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

    <div class="card card-solid">
        <div class="card-body pb-0">
          <div class="row">
            @foreach ($users as $user)
            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                <div class="card bg-light d-flex flex-fill">
                  <div class="card-header text-muted border-bottom-0">
                    {{ $user->name }}
                  </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <p class="text-muted text-sm mt-3"><b>Beosztás : {{ $user->rank }} </b> </p>
                      <form id="deleteForm" action="{{ route('delete') }}" method="post">
                      @csrf
                      <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li class="medium mt-3"><span class="fa-li"><i class="fas fa-lg fa-envelope"></i></span> Email: {{ $user->email }}</li>
                        <li class="medium mt-3"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Végzettség: {{ $user->education }}</li>
                        <li class="medium mt-3"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Telefonszám: {{ $user->mobile_number }}</li>
                      </ul>
                    </div>
                    <div class="col-5 d-flex align-items-center justify-content-center">
                      <img src="images/nurse_profil.svg" alt="user-avatar" class="img-circle img-fluid">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                    <div class="row justify-content-end">
                      <div class="mr-2">
                        <button class="btn btn-sm bg-teal">
                          <i class="fas fa-comments"></i>
                        </button>
                      </div>
                      <div class="mr-3">
                          <input type="hidden" name="name" id="name" value= "{{ $user->name }}">
                          <button onclick="confirmDelete()" class="btn btn-sm btn-danger" name="submit_button" value={{ $user->email }}>
                            <i class="fas fa-user"></i> Eltávolítás
                          </button>
                        </form>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
            @endforeach

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Dolgozó regisztrálás</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-3 col-form-label">Teljes név</label>
                        <div class="col-sm-9">
                        <input type="text" class="form-control" id="inputName" >
                        </div>
                    </div>
                    <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="inputEmail">
                    </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-sm-3">Végzettség</label>
                    <div class="col-sm-9">
                        <select class="form-control select2 select2-hidden-accessible" data-select2-id="1" tabindex="-1" aria-hidden="true" id="selectedEducation">
                            <option value="" selected disabled hidden> </option>
                            <option data-select2-id="1">Segédápoló</option>
                            <option data-select2-id="2">Gyakorló ápoló</option>
                            <option data-select2-id="3">Szakápoló</option>
                            <option data-select2-id="4">Diplomás ápoló (bsc)</option>
                            <option data-select2-id="5">Diplomás ápoló (msc)</option>
                        </select>
                    </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3">Beosztás</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputRank" value=" " placeholder="(nem kötelező)">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégse</button>
              <button class="btn btn-primary" onclick="save()">Megerősítő kód küldés</button>
            </div>
      </div>
    </div>
  </div>
</div>
<script src="/js/HeadNursePages/addEmployer.js"></script>
@endsection
