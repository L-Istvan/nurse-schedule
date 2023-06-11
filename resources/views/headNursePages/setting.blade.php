@extends('layouts.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
<link rel="stylesheet" href="{{asset('css/setting.css')}}">
<div class="content-wrapper">

    <div class="box">
        <div class="month">
            <ul>
              <li class="left"> <a class="nav-link" data-widget="pushmenu" role="button"><i class="fas fa-bars"></i></a></li>
              <li>
                <label>Beállítás</label><br>
              </li>
            </ul>
        </div>
    </div>



    <div class="row container">
        <!----------------------------------------------------------------------------------------------------------------------------->
        <!-- ------------------------------------------------first column ------------------------------------------------------------->
        <!----------------------------------------------------------------------------------------------------------------------------->
        <div class="col-0 col-xl-1">
        </div>
        <!----------------------------------------------------------------------------------------------------------------------------->
        <!---------------------------------------------------second column------------------------------------------------------------->
        <!----------------------------------------------------------------------------------------------------------------------------->
        <div class="ml-4 col-12 col-xl-7 .custom-margin-right">

            <!-- ------------------------------------------------------------------------>
            <h1 class="underline-extended">Munka Beosztás</h1>
            <div class="d-flex justify-content-between">
                <div>
                    <h2>Egy napon <strong>maximum</strong> dolgozók száma</h2>
                </div>
                <div>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="maxWorkerInOneDay" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{$setting[0]->maxNumberOfWorkersInOnday}}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            @for ($i=1;$i<=10;$i++)
                            <button id="maxWorkerInOneDay" class="dropdown-item" type="button" href="/gfd">{{$i}}</button>
                            @endfor
                        </div>
                    </div>
                </div>
           </div>
            <!-- --------------------------------------------------------------------------->
           <div class="d-flex justify-content-between mt-4">
            <div>
                <h2>Egy napon <strong>minimum</strong> dolgozók száma</h2>
            </div>
            <div>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="minWorkerInOneDay" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{$setting[0]->minNumberOfWorkersInOnday}}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        @for ($i=1;$i<=10;$i++)
                        <button id="minWorkerInOneDay" class="dropdown-item" type="button" href="/gfd">{{$i}}</button>
                        @endfor
                    </div>
                </div>
            </div>
          </div>
          <!-- --------------------------------------------------------------------------->
          <div class="d-flex justify-content-between mt-4">
            <div>
                <h2><strong>Nappalok</strong> száma egy hónapra</h2>
            </div>
            <div>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="day" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      {{$setting[0]->numberOfDays}}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        @for ($i=1;$i<=10;$i++)
                        <button id="day" class="dropdown-item" type="button" href="#">{{$i}}</button>
                        @endfor
                    </div>
                </div>
            </div>
          </div>
          <!-- --------------------------------------------------------------------------->
          <div class="d-flex justify-content-between mt-4">
            <div>
                <h2><strong>Éjszakák</strong> száma egy hónapra</h2>
            </div>
            <div>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="night" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{$setting[0]->numberOfNights}}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        @for ($i=1;$i<=10;$i++)
                        <button id="night" class="dropdown-item" type="button" href="#">{{$i}}</button>
                        @endfor
                    </div>
                </div>
            </div>
          </div>
        <!-- -------------------------------Holiday------------------------------------->
        <!-- --------------------------------------------------------------------------->
        <h1 class="underline-extended">Szabadság</h1>
        <div class="d-flex justify-content-between mt-4">
            <div>
                <h2>Kivehető maximum szabadság <strong>egy évre</strong></h2>
            </div>
            <div>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="holidayAllowanceForOneYear" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{$setting[0]->maxYearHoliday}}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        @for ($i=25;$i<=35;$i++)
                        <button id="holidayAllowanceForOneYear" class="dropdown-item" type="button" href="#">{{$i}}</button>
                        @endfor
                    </div>
                </div>
            </div>
          </div>
        <!------------------------------------------------------------------------------>
        <div class="d-flex justify-content-between mt-4">
            <div>
                <h2>Kivehető maximum szabadság <strong>egy hónapra</strong></h2>
            </div>
            <div>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="holidayAllowanceForOneMonth" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{$setting[0]->maxMonthHoliday}}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        @for ($i=5;$i<=15;$i++)
                        <button id="holidayAllowanceForOneMonth" class="dropdown-item" type="button" href="#">{{$i}}</button>
                        @endfor
                    </div>
                </div>
            </div>
          </div>
          <!----------------------------------Rest Day------------------------------------>
          <!------------------------------------------------------------------------------>
          <h1 class="underline-extended">Kérés</h1>
          <div class="d-flex justify-content-between mt-4">
            <div>
                <h2>Kérhető pihenőnap száma <strong>egy hónapra</strong></h2>
            </div>
            <div>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="restDayAllowanceForOneMonth" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{$setting[0]->maxPetitons}}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        @for ($i=1;$i<=10;$i++)
                        <button id="restDayAllowanceForOneMonth" class="dropdown-item" type="button" href="#">{{$i}}</button>
                        @endfor
                    </div>
                </div>
            </div>
          </div>
        </div>

        <!----------------------------------------------------------------------------------------------------------------------------->
        <!------------------------------------------------ third column --------------------------------------------------------------->
        <!----------------------------------------------------------------------------------------------------------------------------->
        <div class="col-0 col-xl-4">
        </div>
    </div>

</div>

<script src="js/HeadNursePages/setting.js"></script>
@endsection
