@extends('layouts.app')
@section('content')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js'></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="d-flex justify-content-center">
            <a href="#" class="btn btn-m" data-toggle="modal" data-target="#exampleModal" style="border-radius: 2rem;background-color:#47a0e4;">
                <img src="/dist/img/addemployee.png" alt="">Regisztrálás
            </a>
        </div>
      </div>
    </section>
    <div class="card card-solid">
        <div class="card-body pb-0">
          <div class="row">
              <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                <div class="card bg-light d-flex flex-fill">
                  <div class="card-header text-muted border-bottom-0">
                    Laczi Hajnalka
                  </div>
                  <div class="card-body pt-0">
                    <div class="row">
                      <div class="col-7">
                        <p class="text-muted text-sm mt-3"><b>Beosztás: </b> </p>
                        <ul class="ml-4 mb-0 fa-ul text-muted">
                            <li class="medium mt-3"><span class="fa-li"><i class="fas fa-lg fa-envelope"></i></span> Email: laczihajnalka@gmail.com</li>
                          <li class="medium mt-3"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Végzettség: Diplomás ápoló</li>
                          <li class="medium mt-3"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Telefonszám: +36 30 123456</li>
                        </ul>
                      </div>
                      <div class="col-5 text-center">
                        <img src="dist/img/profileLogo.png" alt="user-avatar" class="img-circle img-fluid">
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="text-right">
                      <a href="#" class="btn btn-sm bg-teal">
                        <i class="fas fa-comments"></i>
                      </a>
                      <a href="#" class="btn btn-sm btn-danger">
                        <i class="fas fa-user"></i> Eltávolítás
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Button trigger modal -->

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
                            <input type="text" class="form-control" id="inputRank" placeholder="(nem kötelező)">
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

<script>
function save(){
    toastr.options = {"positionClass": "toast-top-center"};
    inputName = document.getElementById('inputName').value;
    inputEmail = document.getElementById('inputEmail').value;
    selectedEducation = document.getElementById('selectedEducation').value;
    inputRank = document.getElementById('inputRank').value;
    array = {"inputName" : inputName,"inputEmail": inputEmail,
    "selectedEducation":selectedEducation,"inputRank": inputRank};
    $.ajax({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: '/sendInputEmployee',
        data : JSON.stringify(array),
        contentType: 'application/json',
        complete: function(xhr){
            if (xhr.status == 200) toastr.success(xhr.responseJSON['message']);
            else toastr.error(xhr.responseJSON['message']);

        }
    });

}

</script>

</div>
@endsection

