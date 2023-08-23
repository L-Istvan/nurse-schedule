@extends('layouts.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">

<style>

.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
}

.loading-spinner {
  border: 4px solid rgba(255, 255, 255, 0.3);
  border-top: 4px solid #ffffff;
  border-radius: 50%;
  width: 50px;
  height: 50px;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

</style>


<div class="content-wrapper" style="background-color: rgb(230, 231, 234);">
    Fejlesztés alatt...
    <div id="loading-overlay" class="loading-overlay" style="display: none">
        <div id="loading-spinner" class="loading-spinner"></div>
      </div>
      <button onclick="elso()" style="width: 200px; height:50px"></button>
 </div>

 <script>
    function elso(){
        document.getElementById("loading-overlay").style.display = "flex";

    }

 </script>

 @endsection

