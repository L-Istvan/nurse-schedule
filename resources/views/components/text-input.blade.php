@props(['disabled' => false])

<style>
.input{
    height: 45px;
    width: 80%;
    border:none;
    border-bottom: 1px solid white;
    font-size: 20px;
    padding: 0 0 0 45px;
    background: transparent;
    outline: none;
    margin: auto;
    color: white;
    padding-left: 0;
}
.input::placeholder{
    color: white !important;
    opacity: 1;
}
</style>


<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'input']) !!}>

{{-- border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm --}}
