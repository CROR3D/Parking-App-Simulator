@extends('Centaur::layout')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    @if (Sentinel::check() && Sentinel::inRole('administrator'))
        <div class="row dashboard">
            <div class="page-header">
                <h1>App Analysis</h1>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tbody>
                                <th class="text-left"><h3>Cities</h3></th>
                                <tr>
                                    <td class="text-left">Number of cities: {{ $data['cities']['number'] }}</td>
                                    <td>
                                        <a href="" class="btn btn-default">
                                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                            Show
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left">City with most parking lots: </td>
                                </tr>
                                <th class="text-left"><h3>Parking</h3></th>
                                <tr>
                                    <td class="text-left">Total parking lots: {{ $data['parkings']['number'] }}</td>
                                    <td>
                                        <a href="" class="btn btn-default">
                                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                            Show
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left">Alerts</td>
                                    <td>
                                        <a href="" class="btn btn-danger">
                                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                            Show
                                        </a>
                                    </td>
                                </tr>
                                <th class="text-left"><h3>Users</h3></th>
                                <tr>
                                    <td class="text-left">Registered users currently on parking lots: {{ $data['users']['number'] }}</td>
                                    <td>
                                        <a href="" class="btn btn-default">
                                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                            Show
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left">Messages</td>
                                    <td>
                                        <a href="" class="btn btn-primary">
                                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                            Show
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
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
                <h3>Available funds: {{ $data['account']['funds'] }} kn</h3>
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
