@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="prc_no" class="col-md-4 col-form-label text-md-right">{{ __('PRC Number') }}</label>

                            <div class="col-md-6">
                                <input id="prc_no" type="number" required class="form-control{{ $errors->has('prc_no') ? ' is-invalid' : '' }}" name="prc_no" value="{{ old('prc_no') }}" required autofocus>

                                @if ($errors->has('prc_no'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('prc_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sur" class="col-md-4 col-form-label text-md-right">{{ __('Surname') }}</label>

                            <div class="col-md-6">
                                <input id="sur" type="text" class="form-control{{ $errors->has('sur') ? ' is-invalid' : '' }}" name="sur" value="{{ old('sur') }}" required autofocus>

                                @if ($errors->has('sur'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('sur') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="given" class="col-md-4 col-form-label text-md-right">{{ __('Given Name') }}</label>

                            <div class="col-md-6">
                                <input id="given" type="text" class="form-control{{ $errors->has('given') ? ' is-invalid' : '' }}" name="given" value="{{ old('given') }}" required autofocus>

                                @if ($errors->has('given'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('given') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="middlename" class="col-md-4 col-form-label text-md-right">{{ __('Middle Name') }}</label>

                            <div class="col-md-6">
                                <input id="middlename" type="text" class="form-control{{ $errors->has('given') ? ' is-invalid' : '' }}" name="middlename" value="{{ old('middlename') }}" required autofocus>

                                @if ($errors->has('middlename'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('middlename') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

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
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
