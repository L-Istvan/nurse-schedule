@extends('layouts.app')
@section('content')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js'></script>
<style>
    #calendar {
      max-height: 800px;
      overflow-y: auto;
    }
  </style>
<script>

    var chosen = "Kérés";
    var eventColor = "gray";

    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        selectable: true,
        fixedWeekCount: false,
        unselectAuto: true,
        //plugins: ['dayGrid', 'interaction'],

        // Ha egy eseményre kattintunk
        eventClick: function(info) {
            info.event.remove();
        },

        //Ha 1 napra kattintunk
        select: function(info) {
            var event = calendar.getEventById(info.startStr); // an event object!
            if (event === null){
                console.log('Nincs esemény a kiválasztott napon.');
                calendar.addEvent({
                    id: info.startStr,
                    title: chosen,
                    start: info.startStr,
                    color: eventColor
                });
            }else {
                console.log('Az alábbi események vannak a kiválasztott napon:');
                event.remove();
            }
          }
      });
      calendar.render();
    });

    //----- buttons -----------
    function keres(){
        chosen = "Keres";
        eventColor = 'gray';
    }
    function szabadsag(){
        chosen = "Szabadság";
        eventColor = 'blue';
    }

    function betegSzabadsag(){
        chosen = "Beteg Szabadság";
        eventColor = 'red';
    }

    function mentes(){
        chosen = "save()";
    }

  </script>

<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
          <div class="sticky-top mb-3">
            <div class="card">
              <div class="card-header">
                <h5 class="text-center">Jelenleg</h5>
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
                  <div class="checkbox">
                    <label for="drop-remove">
                      <input type="checkbox" id="drop-remove">
                      törlés
                    </label>
                  </div>
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
