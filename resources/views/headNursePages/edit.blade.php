@extends('layouts.app')
@section('content')

<style>
/****** Tábla ****/
tr{
    cursor: pointer; transition: all .25s ease-in-out
}

table, th, td {
    border:1px solid black;
    border-collapse: collapse;
    table-layout: fixed;
    width : auto;
    min-width: 30px;
    min-height: 30px;
    margin-top: 30px;
    margin-left: auto;
    margin-right: auto;
    text-align: center;
  }

</style>


<div class="content-wrapper">
    <div style="overflow-x:auto;">
    <table id=table>
        {{-- Napok ki iratása--}}
        @for ($i=0;$i < Carbon\Carbon::now()->daysInMonth+1;$i++)
            @if ($i == 0 ) <th scope=col>Nap</th>
            @else <th scope='col'>{{$i}}</th>
            @endif
        @endfor
        {{--  --}}
        @foreach ($userName as $name)
            <tr id={{$i}}> {{-- új sor és id--}}
            <th scope="row">{{ $name }}</th>
            @for ($j=0;$j<Carbon\Carbon::now()->daysInMonth;$j++)
                <td> </td>
            @endfor
            </tr>
        @endforeach
    </table>
    </div>
    <script src="{{ asset('js/HeadNursePages/edit.js') }}"></script>
</div>



@endsection
