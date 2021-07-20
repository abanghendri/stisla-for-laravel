<x-guest-layout>


    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
        <div class="login-brand">
            <img src="{{ asset('') }}/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle">
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Login</h4>
            </div>

            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success mb-3 rounded-0" role="alert">
                    {{ session('status') }}
                </div>
                @endif
                <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
                    @csrf
                    <div class="form-group">
                        <x-jet-label value="{{ __('Email') }}" />
                        <x-jet-input class="{{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email"
                            :value="old('email')" required />
                        <x-jet-input-error for="email"></x-jet-input-error>
                    </div>
                    <div class="form-group">
                        <div class="d-block">
                            <x-jet-label value="{{ __('Password') }}" />
                            @if (Route::has('password.request'))
                            <div class="float-right">
                                <a href="{{ route('password.request') }}" class="text-small">
                                    {{ __('Forgot your password?') }}
                                </a>
                            </div>
                            @endif
                        </div>
                        <x-jet-input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                            type="password" name="password" required autocomplete="current-password" />
                        <x-jet-input-error for="password"></x-jet-input-error>
                    </div>


                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <x-jet-checkbox id="remember_me" name="remember" />
                            <label class="custom-control-label" for="remember_me">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                            {{ __('Log in') }}
                        </button>

                    </div>
                </form>


            </div>
        </div>
        @if (Route::has('register'))
        <div class="mt-5 text-muted text-center">
            Don't have an account? <a href="{{ route('register') }}">{{ __('Create one?') }}</a>
        </div>
        @endif
        <div class="simple-footer">
            Copyright &copy; Stisla 2018
        </div>
    </div>
</x-guest-layout>
