@extends('Centaur::layout')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="row dashboard">
        <div class="page-header">
            <h1>Profile information</h1>
        </div>

        <form accept-charset="UTF-8" role="form" method="post" action="{{ route('profile_form') }}">
        {{ csrf_field() }}
            <div class="profile-row">
                <h4>Username: </h4> <input type="text" name="username" value="{{ ($user_data['username']) ? $user_data['username'] : '' }}"/>
            </div>

            <div class="profile-row">
                <h4>Email: </h4> <input type="text" name="email" value="{{ $user_data['email'] }}"/>
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
                    <h4>Credit card number: </h4> <input type="text" name="credit_card" value="{{ $user_data['credit_card'] }}"/>
                </div>

                <div class="profile-row">
                @if($user_data['credit_card'])
                    <h4>Pull from card: </h4> <input type="number" name="account" min="0"/> kn
                    {!! ($errors->has('account')) ? $errors->first('account', '<p class="text-danger">:message</p>') : '' !!}
                @endif
                </div>
            </div>

            <div class="profile-row">
                <button class="btn btn-md btn-info" type="submit" name="profile_data">Submit data</button>
            </div>
        </form>
    </div>
</div>
@stop
