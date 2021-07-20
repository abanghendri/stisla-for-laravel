<x-guest-layout>
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
        <div class="login-brand">
            <img src="{{ asset('') }}/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle">
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Register</h4>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group">
                        <x-jet-label value="{{ __('Name') }}" />

                        <x-jet-input class="{{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                            :value="old('name')" required autofocus autocomplete="name" />
                        <x-jet-input-error for="name"></x-jet-input-error>
                    </div>

                    <div class="form-group">
                        <x-jet-label value="{{ __('Email') }}" />

                        <x-jet-input class="{{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email"
                            :value="old('email')" required />
                        <x-jet-input-error for="email"></x-jet-input-error>
                    </div>

                    <div class="form-group">
                        <x-jet-label value="{{ __('Password') }}" />

                        <x-jet-input class="{{ $errors->has('password') ? 'is-invalid' : '' }}" type="password"
                            name="password" required autocomplete="new-password" />
                        <x-jet-input-error for="password"></x-jet-input-error>
                    </div>

                    <div class="form-group">
                        <x-jet-label value="{{ __('Confirm Password') }}" />

                        <x-jet-input class="form-control" type="password" name="password_confirmation" required
                            autocomplete="new-password" />
                    </div>

                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <x-jet-checkbox id="terms" name="terms" />
                            <label class="custom-control-label" for="terms">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'">'.__('Terms of
                                    Service').'</a>',
                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'">'.__('Privacy
                                    Policy').'</a>',
                                ]) !!}
                            </label>
                        </div>
                    </div>
                    @endif

                    <div class="mb-0">
                        <div class="row">

                            <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                {{ __('Register') }}
                            </button>
                        </div>
                        <p class="text-center">
                            {{ __('Already registered?')}}
                            <a class=" mt-2 mr-3 text-decoration-none" href="{{ route('login') }}">
                                {{ __('Login') }}
                            </a>
                        </p>
                    </div>
                </form>

            </div>
        </div>
        <div class="simple-footer">
            Copyright &copy; Stisla 2018
        </div>
    </div>
</x-guest-layout>
