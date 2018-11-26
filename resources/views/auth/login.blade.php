@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" style="margin-top: 60px;">
        <div class="col-md-6">
            <div class="card" style="border-radius: 10px;">
                @if (session('status') || session('warning'))
                <div class="alert alert-warning text-center">
                {{ session('status')==''?session('warning'):session('status') }}
                </div>
                @endif
                <div class="card-body" style="background-color: rgba(0, 0, 0, 0.03); "><img src="{{ asset('images/pice_name.png') }}" class="img-fluid" alt="Responsive image" style="margin-bottom: 15px;"/>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        @if (request()->get('tokenid') && App\Http\Util\VerifyUtil::isValidToken(request()->get('tokenid')) == 0)
                        <div class="form-group row">
                            <label for="token" class="col-sm-4 col-form-label text-md-right">Activation Token</label>
                            <div class="col-md-6">
                                <input id="token" type="token" class="form-control" name="token" value="{{ request()->get('tokenid') }}" required>
                            </div>
                        </div>   
                        @endif

                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
