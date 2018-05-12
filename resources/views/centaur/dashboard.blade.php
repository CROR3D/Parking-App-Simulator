@extends('Centaur::layout')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    @if (Sentinel::check() && Sentinel::inRole('administrator'))
        <div class="row dashboard">
            <div class="page-header">
                <div class='btn-toolbar'>
                    <a class="btn btn-primary btn-md" href="{{ route('profile') }}">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        Profile setup
                    </a>
                </div>
                <h1>App Analysis</h1>
            </div>
            <div class="row dashboard">
                <h3>Cities</h3>
                <div class="profile-row">
                    <h4>Number of cities: {{ $data['cities']['number'] }}</h4>
                    <a href="" class="btn btn-default">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                        Show
                    </a>
                </div>
                <div class="profile-row">
                    <h4>City with most parking lots: </h4>
                </div>

                <h3>Parking</h3>
                <div class="profile-row">
                    <h4>Total parking lots: {{ $data['parkings']['number'] }}</h4>
                    <a href="" class="btn btn-default">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                        Show
                    </a>
                </div>

                <div class="profile-row">
                    <h4>Alerts</h4>
                    <a href="" class="btn btn-danger">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                        Show
                    </a>
                </div>

                <h3>Users</h3>
                <div class="profile-row">
                    <h4>Registered users currently on parking lots: {{ $data['users']['number'] }}</h4>
                    <a href="" class="btn btn-default">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                        Show
                    </a>
                </div>

                <h3>Messages</h3>
            </div>
        </div>
    @elseif(Sentinel::check())
        <div class="jumbotron">
            <h3 class="text-danger">Administrator Message</h3>
            @if($admin_msg)
                <h4>Parking lot 'Foša' in Zadar will be closed 01.06.2018!</h4>
            @else
                <h4>There is no messages.</h4>
            @endif
        </div>
        <div class="row dashboard">
            <div class="page-header">
                <div class='btn-toolbar pull-right'>
                    <a class="btn btn-primary btn-md" href="{{ route('profile') }}">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        Profile setup
                    </a>
                </div>
                <h1>Dashboard</h1>
            </div>
            <div class="row dashboard">
                <h3>Reservations</h3>
                <h4>Last reservation: </h4>
                <h4>Total reservations: </h4>
                <h4>Most visited parking lot: </h4>
            </div>
        </div>
    @else
        <div class="jumbotron">
            <h1>Welcome, Guest!</h1>
            <p>You must login to continue.</p>
            <p><a class="btn btn-primary btn-lg" href="{{ route('auth.login.form') }}" role="button">Log In</a></p>
        </div>
    @endif
</div>
@stop
