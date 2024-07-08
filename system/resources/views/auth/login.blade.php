@extends('layouts.auth')

@section('content')
<div class="row">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
        <div class="login-brand" style="margin: 0;padding: 40px 70px 20px">
            <img class="bg-white p-2" src="{{ data_get($setting, 'logo', '-') }}" alt="logo" width="100%">
        </div>

        <div class="card card-primary" style="margin-bottom: 0">
            <div class="card-header">
                <h4>{{ __('Login') }}</h4>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('login') }}"   >
                    @csrf

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="d-block">
                            <label for="password" class="control-label">Password</label>
                        </div>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="simple-footer" style="margin: 0;padding: 10px;">
            Copyright &copy; <a href="{{ url('') }}" target="_blank">{{ data_get($setting, 'name', '-') }}</a> {{ date('Y') }}
        </div>
    </div>
</div>
@endsection
