@extends('layouts.app')
@section('content')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js'></script>
<script src="{{ asset('js/nursePageIndex.js') }}"></script>
<style>
    #calendar {
      max-height: 800px;
      overflow-y: auto;
    }
  </style>

<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
          <div class="sticky-top mb-3">
            <div class="card">
              <div class="card-header">
                <h5 class="text-center">Felhasznált</h5>
              </div>
              <div class="card-body">
                <!-- the events -->
                <div class="card">
                <h5 class="text-center mt-3 mb-3">Kérés: 10/2</h5>
                <h5 class="text-center mb-3">Havi Szabadság: 10/3</h5>
                <h5 class="text-center mb-3">Éves szabadság: 10/5</h5>
                <h5 class="text-center mb-4">Beteg szabadság: 10</h5>
                </div>
                <div id="external-events">
                  <button class="btn btn-secondary btn-lg btn-block" onclick="keres()">Kérés</button>
                  <button class="btn btn-primary btn-lg btn-block" onclick="szabadsag()">Szabadság</button>
                  <button class="btn btn-danger btn-lg btn-block" onclick="betegSzabadsag()">Beteg szabadság</button>
                  <button class="btn btn-danger btn-lg btn-block" onclick="mentes()">Mentés</button>
                  <button class="btn btn-danger btn-lg btn-block"  id="getevent">Click me</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card card-primary">
            <div class="card-body p-0">
              <!-- THE CALENDAR -->
              <div id="calendar"></div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
<!-- /.content-wrapper -->

</div>
@endsection
