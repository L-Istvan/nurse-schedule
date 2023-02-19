<style>
    .button{
        display: block;
        border :0;
        width: 75%;
        height: 50px;
        border-radius: 40px;
        background : rgb(71,138,201);
        margin-left: auto;
        margin-right: auto;
    }
</style>
<button {{ $attributes->merge(['type' => 'submit', 'class' => 'button mt-4 mb-6']) }}>
    {{ $slot }}
</button>
