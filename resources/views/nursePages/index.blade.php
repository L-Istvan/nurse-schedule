@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <p>Nővér</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit">Kijelentkezés</button>
    </form>
</div>
@endsection
