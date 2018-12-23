@extends('Centaur::layout')

@section('title', 'Dashboard')

@section('content')
<div class="row dashboard">

    @if(Sentinel::check())
        <div class="profile-row">
            <h1 class="section-title">User Information</h1>
        </div>
        <div class="profile-row">
            <a href="{{ route('profile') }}" class="btn btn-info profile-right">
                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                Profile Settings
            </a>
        </div>
        <div class="jumbotron info-row">

            <div class="profile-row">
                <h3>Account balance: <span class="text-success">{{ ($data['account']) ? $data['account'] : 0 }}</span> kn</h3>
            </div>
            <div class="profile-section">
                <h3 class="text-primary">Current reservation: </h3>
                    <div class="profile-row">
                        @if($data['users']['reservation']['city'])
                            <h4>City: <span class="text-success">{{ $data['users']['reservation']['city'] }}</span></h4>
                            <h4>Parking: <span class="text-success">{{ $data['users']['reservation']['parking'] }}</span></h4>
                            <h4>Reservation created: <span class="text-success">{{ $data['users']['reservation']['time'] }}</span></h4>
                            <h4>Reservation expires: <span class="text-success">{{ $data['users']['reservation']['expires'] }}</span></h4>
                            <h4>Access code: <span class="text-danger">{{ $data['users']['reservation']['code'] }}</span></h4>
                        @else
                            <h4 class="text-success">No reservation at the moment</h4>
                        @endif
                </div>
            </div>
            <div class="profile-section">
                <h3 class="text-primary">Pay ticket: </h3>
                    <div class="profile-row">
                        <h4>Ticket code: </h4>
                        <form accept-charset="UTF-8" role="form" method="post" action="{{ route('dashboard_form') }}">
                        {{ csrf_field() }}
                            <div class="profile-row">
                                <input type="text" name="ticket_code" value="">

                                <button id="pay_ticket" type="submit" class="btn btn-success profile-next-right">
                                    Pay Ticket
                                </button>
                            </div>
                        </form>
                </div>
            </div>
            @if(Sentinel::inRole('administrator'))
            <div class="profile-row">
                <h3 class="text-primary">Messages</h3>
            </div>
            <div class="profile-section">
                <div class="profile-row">
                    <h4 class="profile-left">Make notification for all users</h4>
                    <a href="{{ route('message') }}" class="btn btn-default profile-right">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                        Write
                    </a>
                </div>
            </div>
            <div class="profile-section">
                <div class="profile-row">
                    <h4 class="profile-left">View messages</h4>
                    <a href="{{ route('messages') }}" class="btn btn-default profile-right">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                        View
                    </a>
                </div>
            </div>
            @endif
        </div>

    @endif

    @if (Sentinel::check() && Sentinel::inRole('administrator'))
        <div class="profile-row">
            <h1 class="section-title">App Analysis</h1>
        </div>
        <div class="jumbotron info-row">
            <div class="profile-row">
                <h3 class="text-primary">Cities</h3>
            </div>
            <div class="profile-section">
                <div class="profile-row">
                    <h4 class="profile-left">Number of cities supporting aplication: {{ $data['cities']['number'] }}</h4>
                    <a href="{{ route('show', ['data' => 'cities']) }}" class="btn btn-default profile-right">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                        Show
                    </a>
                </div>
                <div class="profile-row">
                    <h4 class="profile-left">City with most parking lots is {{ $data['cities']['most_lots'] }}</h4>
                </div>
            </div>

            <div class="profile-row">
                <h3 class="text-primary">Parking</h3>
            </div>
            <div class="profile-section">
                <div class="profile-row">
                    <h4 class="profile-left">Number of parking lots supporting application: {{ $data['parkings']['number'] }}</h4>
                    <a href="{{ route('show', ['data' => 'parking']) }}" class="btn btn-default profile-right">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                        Show
                    </a>
                </div>
            </div>

            <div class="profile-row">
                <h3 class="text-primary">Users</h3>
            </div>
            <div class="profile-section">
                <div class="profile-row">
                    <h4 class="profile-left">Number of registered users currently on parking lots: {{ $data['users']['number'] }}</h4>
                    <a href="{{ route('show', ['data' => 'users']) }}" class="btn btn-default profile-right">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                        Show
                    </a>
                </div>
            </div>
        </div>
    @endif

    @if(Sentinel::check() && !Sentinel::inRole('administrator'))
        <div class="profile-section">
            <h1 class="text-danger">Administrator Messages</h1>
        </div>
        <div class="profile-section">
            @if($admin_msg)
                @foreach($admin_msg as $msg)
                <div class="profile-row">
                    <h3>{{ $msg['title'] }}</h3>
                    <h4>{{ $msg['content'] }}</h4>
                </div>
                @endforeach
            @else
                <h4>There are no messages.</h4>
            @endif
        </div>
    @endif

    @if(!Sentinel::check())
        <div class="jumbotron">
            <h1>Welcome, Guest!</h1>
            <p>You must login to continue.</p>
            <p><a class="btn btn-primary btn-lg" href="{{ route('auth.login.form') }}" role="button">Log In</a></p>
        </div>
    @endif
</div>
@stop
