@extends('Centaur::layout')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="row dashboard">
        <div class="page-header">
            <h1>Profile information</h1>
        </div>

        <form accept-charset="UTF-8" role="form" method="post" action="">
        {{ csrf_field() }}
            <div class="profile-row">
                <h4>Username: </h4> <input type="text" value="{{ ($user_data['username']) ? $user_data['username'] : '' }}"/>
            </div>

            <div class="profile-row">
                <h4>Email: </h4> <input type="text" value="{{ $user_data['email'] }}"/>
            </div>

            <div class="profile-section">
                <h4>Change password: </h4>
                <div class="profile-row">
                    <h4>Old password: </h4> <input type="text"/>
                </div>

                <div class="profile-row">
                    <h4>New password: </h4> <input type="password"/>
                </div>

                <div class="profile-row">
                    <h4>Confirm new password: </h4> <input type="password"/>
                </div>
            </div>

            <div class="profile-section">
                <h4>Credit card information</h4>
                <div class="profile-row">
                    <h4>Credit card number: </h4> <input type="text"/>
                </div>
            </div>

            <div class="profile-row">
                <button class="btn btn-md btn-info" type="submit" name="username">Submit data</button>
            </div>
        </form>
    </div>
</div>
@stop
