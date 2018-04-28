@extends('Centaur::layout')

@section('title', 'City Parking')

@push('custom-css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/index.css') }}">
@endpush

@section('content')
    <div class="index-page">
        <div class="container">
            <div class="index-logo">
                <img class="img-responsive" src="{{ URL::asset('images/logo.svg') }}"/>
            </div>
            <div class="frame">
                <div class="slider">
            <div class="login">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Login</h3>
                    </div>
                    <div class="panel-body">
                        <form accept-charset="UTF-8" role="form" method="post" action="{{ route('auth.login.attempt') }}">
                            <fieldset>
                                <div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }}">
                                    <input class="form-control" placeholder="E-mail" name="email" type="text" value="{{ old('email') }}">
                                    {!! ($errors->has('email') ? $errors->first('email', '<p class="text-danger">:message</p>') : '') !!}
                                </div>
                                <div class="form-group  {{ ($errors->has('password')) ? 'has-error' : '' }}">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                    {!! ($errors->has('password') ? $errors->first('password', '<p class="text-danger">:message</p>') : '') !!}
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="true" {{ old('remember') == 'true' ? 'checked' : ''}}> Remember Me
                                    </label>
                                </div>
                                <input name="_token" value="{{ csrf_token() }}" type="hidden">
                                <input class="btn btn-lg btn-primary btn-block" type="submit" value="Login">
                                <p style="margin-top:5px; margin-bottom:0"><a href="{{ route('auth.password.request.form') }}" type="submit">Forgot your password?</a></p>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <a id="go_to_register">Don't have an account? Register here</a>
            </div>
            <div class="register">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Register</h3>
                    </div>
                    <div class="panel-body">
                        <form accept-charset="UTF-8" role="form" method="post" action="{{ route('auth.register.attempt') }}">
                            <fieldset>
                                <div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }}">
                                    <input class="form-control" placeholder="E-mail" name="email" type="text" value="{{ old('email') }}">
                                    {!! ($errors->has('email') ? $errors->first('email', '<p class="text-danger">:message</p>') : '') !!}
                                </div>
                                <div class="form-group  {{ ($errors->has('password')) ? 'has-error' : '' }}">
                                    <input class="form-control" placeholder="Password" name="password" type="password">
                                    {!! ($errors->has('password') ? $errors->first('password', '<p class="text-danger">:message</p>') : '') !!}
                                </div>
                                <div class="form-group  {{ ($errors->has('password_confirmation')) ? 'has-error' : '' }}">
                                    <input class="form-control" placeholder="Confirm Password" name="password_confirmation" type="password">
                                    {!! ($errors->has('password_confirmation') ? $errors->first('password_confirmation', '<p class="text-danger">:message</p>') : '') !!}
                                </div>
                                <input name="_token" value="{{ csrf_token() }}" type="hidden">
                                <input class="btn btn-lg btn-primary btn-block" type="submit" value="Sign Me Up!">
                            </fieldset>
                        </form>
                    </div>
                </div>
                <a id="go_to_login">Log in with your account here</a>
            </div>
        </div>
            </div>
            <div class="simulator">
                <a class="btn btn-success btn-block" href="#">PARKING SIMULATOR</a>
            </div>
        </div>
    </div>
@stop

@push('script')
    <script>
        $(document).ready(function() {
            $('#go_to_login').click(function() {
                $('.slider').animate({
                'marginTop' : "+=350px"
                });
            });

            $('#go_to_register').click(function() {
                $('.slider').animate({
                'marginTop' : "-=350px"
                });
            });
        });
    </script>
@endpush
