@extends('layouts.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">

<div class="content-wrapper">
    <div class="box">
        <div class="month">
            <ul>
              <li class="left" style="margin-top:5px"> <a class="nav-link" data-widget="pushmenu" role="button"><i class="fas fa-bars"></i></a></li>
              <li class="prev" onclick="prev()">&#10094;</li>
              <li class="next" onclick="next()">&#10095;</li>
              <li>
                <label id="month"></label><br>
                <span id="year" style="font-size:18px"></span>
              </li>
            </ul>
        </div>
    </div>

  <div class="row container-fluid mt-1 justify-content-center">
    <div class="col-auto text-center">
      <div class="d-flex align-items-center">
          <div class="square ml-1" style="background-color: #3e7eb3"></div>
          <span class="align-middle mr-3">Nappal</span>
          <div class="square" style="background-color: #393e46;"></div>
          <span>Éjszaka</span>
      </div>
    </div>
    <div class="col-auto flex-grow-1 text-center">
      <button class="" onclick="create_schedule()">Beosztás készítés</button>
      <button class="" onclick="save()">Beosztás Mentés</button>
      <button class="" onclick="drop()">Beosztás Törlés</button>
    </div>
    <div class="col-auto invisible">
      xxxxxxxxxxxxxxxxxx
    </div>
  </div>


  <div style="overflow-x:auto;">
    <table id="table" class="mt-3">
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
    <script src="{{ asset('js/HeadNursePages/edit.js') }}"></script>
</div>
</div>

</div>

@endsection
