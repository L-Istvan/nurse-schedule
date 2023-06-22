@extends('layouts.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{asset('css/setting.css')}}">
<div class="content-wrapper" style="background-color: rgb(237, 242, 248);">

        <div class="header">
            <ul>
              <li class="left"> <a class="nav-link" data-widget="pushmenu" role="button"><i class="fas fa-bars"></i></a></li>
            </ul>
        </div>


    <div class="row ml-auto mr-auto" style="max-width: 1920px">
        <div class="col-12 col-md-6 col-xl-6">
            <h1 class="underline-extended">Munka Beosztás</h1>
            <div class="d-flex justify-content-between">
                <div>
                    <h2>Egy napon <strong>maximum</strong> dolgozók száma</h2>
                    <em>Dolgozók száma nappal</em>
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
                <em>Dolgozók száma éjszaka</em>
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
                <em>Dolgozóknak hány nappalos műszakuk legyen</em>
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
                <em>Dolgozóknak hány éjszakás műszakuk legyen</em>
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
          <!-- --------------------------------------------------------------------------->
          <div class="d-flex justify-content-between mt-4">
            <div>
                <h2><strong>Munka órák</strong> kiegyenlítési ideje hónap száma szerint</h2>
                <em></em>
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

        <h1 class="underline-extended">Kérés</h1>
          <div class="d-flex justify-content-between mt-4">
            <div>
                <h2>Kérhető pihenőnap száma <strong>egy hónapra</strong></h2>
                <em>Dolgozó mennyi kijelölt pihenő napot kérhet </em>
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
        <!----------------------------------- rigth column --------------------------------------------------->
        <div class="col-0 col-md-6 col-xl-6">

            <!-------------------------------------------------------------------------------------------------------------------------->
            <h1 class="underline-extended">Beosztás finomhangolása</h1>
            <em>Az X jelőli a pihenő napot és a fizetett szabadságot</em>
                <div class="row mt-3">

                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                X-<strong>nappal</strong>-X
                            </label>
                          </div>
                    </div>

                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                X-<strong>éjszaka</strong>-X
                            </label>
                          </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                X-<strong>nappal</strong>-<strong>nappal</strong>-X
                            </label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                X-<strong>éjszaka</strong>-<strong>éjszaka-</strong>X
                            </label>
                        </div>
                    </div>

                </div>

                <div class="row mt-3">
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                X-<strong>nappal</strong>-<strong>éjszaka-</strong>X
                            </label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                X-<strong>éjszaka</strong>-<strong>nappal-</strong>X
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                X-<strong>nappal</strong>-<strong>nappal-</strong><strong>éjszaka</strong>-X
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                X-<strong>nappal</strong>-<strong>éjszaka-</strong><strong>éjszaka</strong>-X
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                X-<strong>nappal</strong>-<strong>nappal-</strong><strong>nappal</strong>-X
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                X-<strong>éjszaka</strong>-<strong>éjszaka-</strong><strong>éjszaka</strong>-X
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                X-<strong>éjszaka</strong>-<strong>nappal-</strong><strong>nappal</strong>-X
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                X-<strong>éjszaka</strong>-<strong>éjszaka-</strong><strong>nappal</strong>-X
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                X-<strong>nappal</strong>-<strong>éjszaka-</strong><strong>nappal</strong>-X
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                X-<strong>éjszaka</strong>-<strong>nappal-</strong><strong>éjszaka</strong>-X
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                X-<strong>nappal</strong>-<strong>éjszaka-</strong><strong>nappal</strong>-X
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                X-<strong>éjszaka</strong>-<strong>nappal-</strong><strong>éjszaka</strong>-X
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                               <strong>Foyltonos</strong> ciklusos beosztás : <strong>nappal</strong>-<strong>éjszaka</strong>-<strong>pihenő</strong> és újra
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <h1 class="underline-extended">Értesítések</h1>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Automatikus értesítés ha készen van az újabb beosztás
                            </label>
                        </div>
                    </div>
                </div>
        </div>
</div>

<script src="js/HeadNursePages/setting.js"></script>
@endsection
