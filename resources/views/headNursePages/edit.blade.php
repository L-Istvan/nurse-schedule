@extends('layouts.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">

<div class="content-wrapper" style="background-color: rgb(237, 242, 248);">
    <a class="nav-link" data-widget="pushmenu" role="button"><i class="fas fa-bars"></i></a>
    <div class="card mx-auto mt-4 mb-4" style="max-width: 1210px;">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-12">
                  <div class="row">
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <label class="switch mx-2">
                              <input class="switch1" type="checkbox" id="switch1">
                              <span class="slider">
                                <svg class="slider-icon" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation"><path fill="none" d="m4 16.5 8 8 16-16"></path></svg>
                              </span>
                            </label>
                            <label for="switch">Nappal</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <label class="switch mx-2">
                              <input class="switch2" type="checkbox" id="switch2">
                              <span class="slider">
                                <svg class="slider-icon" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation"><path fill="none" d="m4 16.5 8 8 16-16"></path></svg>
                              </span>
                            </label>
                            <label for="switch">Szabadság</label>
                        </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <label class="switch mx-2">
                              <input class="switch3" type="checkbox" id="switch3">
                              <span class="slider">
                                <svg class="slider-icon" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation"><path fill="none" d="m4 16.5 8 8 16-16"></path></svg>
                              </span>
                            </label>
                            <label for="switch">Éjszaka</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <label class="switch mx-2">
                              <input class="switch4" type="checkbox" id="switch4">
                              <span class="slider">
                                <svg class="slider-icon" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation"><path fill="none" d="m4 16.5 8 8 16-16"></path></svg>
                              </span>
                            </label>
                            <label for="switch">Betegsz.</label>
                        </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                            <div class="d-flex align-items-center">
                                <label class="switch mx-2">
                                <input class="switch5" type="checkbox" id="switch5">
                                <span class="slider">
                                    <svg class="slider-icon" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation"><path fill="none" d="m4 16.5 8 8 16-16"></path></svg>
                                </span>
                                </label>
                                <label for="switch">Kérés</label>
                            </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <label class="switch mx-2">
                              <input class="switch6" type="checkbox" id="switch6">
                              <span class="slider">
                                <svg class="slider-icon" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation"><path fill="none" d="m4 16.5 8 8 16-16"></path></svg>
                              </span>
                            </label>
                            <label for="switch">Összes</label>
                        </div>
                    </div>
                  </div>
                </div>


            <div class="col-md-6 col-0 my-auto">
                <div class="row ml-0 ml-md-5 mt-3 mt-md-0">
                    <div class="col-xl-6 col-lg-6 col-6  mb-2 text-left">
                        <button class="writing" onclick="create_schedule()"></button>
                        <span>Tervezés</span>
                    </div>
                    <div class="col-xl-6 col-lg-0 col-6 mb-2 text-left">
                        <button class="delete" onclick="drop()"></button>
                        <span>Törlés</span>
                    </div>
                </div>
                <div class="row ml-0 ml-md-5">
                    <div class="col-xl-6 col-lg-6 col-6  mb-2 text-left">
                        <button class="save" onclick="save()"></button>
                        <span>Mentés</span>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-6 mb-2 text-left">
                        <button class="pdf" onclick="drop()"></button>
                        <span>PDF</span>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>


<div class="card mx-auto" style="max-width: 1210px;">
 <div class="card-body">
            <div class="month">
                <ul class="d-flex justify-content-between align-items-center">
                <li class="prev" onclick="prev()">&#10094;</li>
                <li class="d-flex align-items-center">
                    <span id="month" style="font-size:18px; margin-right:10px;"></span>
                    <span id="year" style="font-size:18px"></span>
                </li>
                <li class="next" onclick="next()">&#10095;</li>
                </ul>
            </div>
  <div style="overflow-x:auto;">
    <table id="table" class="">
        <section class="table-header">

        </section>
        {{-- Napok ki iratása--}}
        @for ($i=0;$i < 32;$i++)
            @if ($i == 0 ) <th scope=col>Nap</th>
            @else <th class={{$i}} scope='col'>{{$i}}</th>
            @endif
        @endfor
        {{--  --}}
        @foreach ($getUser as $key=>$user)
        <tr id= {{ $user['id'] }}>  {{-- új sor és id--}}
            <th class="0"> {{ $user['name'] }}</th>
            @for ($j=0;$j<31;$j++)
                <td class={{$j+1}}> </td>
            @endfor
        </tr>
        @endforeach
    </table>
  </div>
    <script src="{{ asset('js/HeadNursePages/edit.js') }}"></script>
</div>
</div>
</div>
</div>

@endsection
