@extends('Centaur::layout')

@section('title', 'Dashboard')

@section('content')
<div class="row dashboard">
    @if (Sentinel::check() && Sentinel::inRole('administrator'))
        <div class="profile-row">
            <h1>App Analysis</h1>
        </div>
        <div class="profile-row">
            <a href="{{ route('profile') }}" class="btn btn-default profile-right">
                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                Profile Settings
            </a>
        </div>
        <div class="profile-row">
            <h3>Cities</h3>
        </div>
        <div class="profile-section">
            <div class="profile-row">
                <h4 class="profile-left">Number of cities supporting aplication: {{ $data['cities']['number'] }}</h4>
                <a href="" class="btn btn-default profile-right">
                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                    Show
                </a>
            </div>
            <div class="profile-row">
                <h4 class="profile-left">City with most parking lots is {{ $data['cities']['most_lots'] }}</h4>
            </div>
        </div>

        <div class="profile-row">
            <h3>Parking</h3>
        </div>
        <div class="profile-section">
            <div class="profile-row">
                <h4 class="profile-left">Number of parking lots supporting application: {{ $data['parkings']['number'] }}</h4>
                <a href="" class="btn btn-default profile-right">
                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                    Show
                </a>
            </div>
        </div>

        <div class="profile-row">
            <h3>Users</h3>
        </div>
        <div class="profile-section">
            <div class="profile-row">
                <h4 class="profile-left">Number of registered users currently on parking lots: {{ $data['users']['number'] }}</h4>
                <a href="" class="btn btn-default profile-right">
                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                    Show
                </a>
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

    @else
        <div class="jumbotron">
            <h1>Welcome, Guest!</h1>
            <p>You must login to continue.</p>
            <p><a class="btn btn-primary btn-lg" href="{{ route('auth.login.form') }}" role="button">Log In</a></p>
        </div>
    @endif
</div>
@stop
