@extends('layouts.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">

<div class="content-wrapper">
    <div class="box">
            <div class="month">
                <ul>
                  <li class="prev" onclick="prev()">&#10094;</li>
                  <li class="next" onclick="next()">&#10095;</li>
                  <li>
                    <label id="month"></label><br>
                    <span id="year" style="font-size:18px"></span>
                  </li>
                </ul>
            </div>
    </div>
        <div class="row d-flex justify-content-center mt-1">
          <div class="col-auto">
            <div class="d-flex align-items-center">
                <div class="square ml-1" style="background-color: #3e7eb3"></div>
                <span class="align-middle mr-3">Nappal</span>
                <div class="square" style="background-color: #393e46;"></div>
                <span>Éjszaka</span>
            </div>
          </div>
          <div class="col-auto flex-grow-1 text-center">
            <button class="">Beosztás készítés</button>
            <button class="" onclick="save()">Beosztás mentés</button>
          </div>
          <div class="col-auto invisible">
            Nappal   Éjszaka
          </div>
        </div>



    <table id="table" class="mt-3">
        {{-- Napok ki iratása--}}
        @for ($i=0;$i < Carbon\Carbon::now()->daysInMonth+1;$i++)
            @if ($i == 0 ) <th scope=col>Nap</th>
            @else <th scope='col'>{{$i}}</th>
            @endif
        @endfor
        {{--  --}}
        @foreach ($getUser as $user)
        <tr id= {{ $user['email'] }}>  {{-- új sor és id--}}
            <th scope="row">{{ $user['name'] }}</th>
            @for ($j=0;$j<Carbon\Carbon::now()->daysInMonth;$j++)
                <td> </td>
            @endfor
        </tr>
        @endforeach
    </table>
    <script src="{{ asset('js/HeadNursePages/edit.js') }}"></script>
</div>

@endsection
