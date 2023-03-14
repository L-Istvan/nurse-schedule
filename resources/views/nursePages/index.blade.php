@extends('layouts.app')
@section('content')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js'></script>
<script src="{{ asset('js/nursePageIndex.js') }}"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
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
                @if ($settingArray->first())
                    <h5 class="text-center mt-3 mb-3">Kérés:
                        <span id="maxPetitons">{{$settingArray->first()->maxPetitons}} </span> /
                        <span id="currentPetitons">{{$settingArray->first()->currentPetitons}}</span>
                    </h5>
                    <h5 class="text-center mb-3">Havi Szabadság:
                        <span id="maxMonthHoliday">{{$settingArray->first()->maxMonthHoliday}} </span> /
                        <span id="currentMonthHoliday">{{$settingArray->first()->currentMonthHoliday}}</span>
                    </h5>
                    <h5 class="text-center mb-3">Éves szabadság:
                        <span id="maxYearHoliday">{{$settingArray->first()->maxYearHoliday}} </span> /
                        <span id="currentYearHoliday">{{$settingArray->first()->currentYearHoliday}}</span>
                    </h5>
                    <h5 class="text-center mb-4">Beteg szabadság:
                        0
                    </h5>
                @else
                    <h5 class="text-center mt-3 mb-3">Kérés: - / -</h5>
                    <h5 class="text-center mb-3">Havi Szabadság: - / -
                    </h5>
                    <h5 class="text-center mb-3">Éves szabadság: - / -
                    </h5>
                    <h5 class="text-center mb-4">Beteg szabadság: -
                    </h5>
                @endif
                </div>
                <div id="external-events">
                  <button class="btn btn-secondary btn-lg btn-block" onclick="keres()">Kérés</button>
                  <button class="btn btn-primary btn-lg btn-block" onclick="szabadsag()">Szabadság</button>
                  <button class="btn btn-danger btn-lg btn-block" onclick="betegSzabadsag()">Beteg szabadság</button>
                  <button class="btn btn-danger btn-lg btn-block" onclick="save()">Mentés</button>
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
