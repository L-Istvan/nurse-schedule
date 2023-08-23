<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <link rel="stylesheet" href="{{ asset("css/login.css") }}">
    <div class="text-center">
        <select id="roleSelector" class="select" width="100px">
            <option value="" selected disabled hidden>Weboldal kiprobáláshoz kattints ide</option>
            <option id="headNurse">Főnővérként</option>
            <option id="nurse">Nővérként</option>
        </select>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-text-input id="email" class="block mt-1 w-full"
                            placeholder="Felhasználónév"
                            type="email"
                            name="email" :value="old('email')"
                            required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-text-input id="password" class="block mt-1 w-full "
                            type="password"
                            name="password"
                            placeholder="Jelszó"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="d-flex justify-content-between text-white" style="margin-top:38px; margin-bottom:38px;">
            <div class="text-left">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2">{{ __('Emlékezz rám') }}</span>
            </div>
            <div class="text-right">
                <a class="" href="{{ route('password.request') }}">
                {{ __('Elfejtetted a jelszavadat?') }}
                </a>
            </div>
        </div>
        <x-primary-button>
            {{ __('Bejelentkezés') }}
        </x-primary-button>
            <div class="block text-center">
                <a href="{{route('register')}}" class="text-white">Még nem regisztrált?</a>
            </div>
        </div>
    </form>
    <script src="{{ asset('js/demo-login.js') }}"></script>
</x-guest-layout>
