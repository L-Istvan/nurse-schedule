@extends('layouts.app')
@section('content')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js'></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          dayBorderColor: 'black',
        });
        calendar.render();
      });
    </script>

<style>
    .vmi{
        background-image: url('/images/opacity_background.JPEG');
        background-size: cover;
    }
    #calendar{
        background-color: rgba(255,255,255, 0.2);
        color:black;
    }
    .card{
        background-color: rgba(0,0,0, 0.2);
    }
    .fc-theme-standard td, .fc-theme-standard th {
        border: 1px solid #000;
        border-right-width: 1.5px;
        border-bottom-width: 1.5px;
    }
    .fc-theme-standard .fc-scrollgrid {
        border: 1px solid #000;
    }
    .fc .fc-daygrid-day.fc-day-today {
        background-color: rgba(255,255,255, 0.4);
    }
    .btn-success{
        background-color: rgb(9, 147, 20);
    }
</style>

<div class="content-wrapper vmi">
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
                  <!-- the events -->
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
    <!-- /.content -->
  <!-- /.content-wrapper -->
  </div>
  @endsection
