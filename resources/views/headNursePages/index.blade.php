@extends('layouts.app')
@section('content')
<script src="{{ asset('js/table/index.global.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<div class="content-wrapper background">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <div class="sticky-top mt-5">
              <div class="card">
                <div class="card-header text-white">
                  <h5 class="text-center">Felhasznált</h5>
                </div>
                <div class="card-body">
                  <!-- Event -->
                  <div class="card text-white">
                      <h5 class="text-center mt-3 mb-3">Kérés: - / -</h5>
                      <h5 class="text-center mb-3">Havi Szabadság: - / -
                      </h5>
                      <h5 class="text-center mb-3">Éves szabadság: - / -
                      </h5>
                      <h5 class="text-center mb-4">Beteg szabadság: -
                      </h5>
                  </div>
                  <div id="external-events">
                    <button class="btn btn-success btn-lg btn-block" onclick="keres()">Kérés</button>
                    <button class="btn btn-primary btn-lg btn-block" onclick="szabadsag()">Szabadság</button>
                    <button class="btn btn-danger btn-lg btn-block" onclick="betegSzabadsag()">Beteg szabadság</button>
                    <button class="btn btn-dark btn-lg btn-block" onclick="save()">Mentés</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-md-9">

                <!-- THE CALENDAR -->
                <div id="calendar"></div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
  </div>
  <script src="js/HeadNursePages/index.js"></script>
  @endsection
