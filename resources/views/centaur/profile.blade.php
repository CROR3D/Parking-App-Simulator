@extends('Centaur::layout')

@section('title', 'Profile')

@section('content')
    <div class="row dashboard">
        <div class="profile-row">
            <h1>Profile Information</h1>
        </div>

        <form accept-charset="UTF-8" role="form" method="post" action="{{ route('profile_form') }}">
        {{ csrf_field() }}

            <div class="profile-row">
                <h4>Username: </h4> <input id="username_input" type="text" name="username" value="{{ ($data['username']) ? $data['username'] : '' }}" readonly/>
                <a id="change_username" class="btn btn-default profile-left">
                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                    Change
                </a>
                <a id="save_username" class="btn btn-default profile-left">
                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                    Save Changes
                </a>
                {!! ($errors->has('username')) ? $errors->first('username', '<p class="text-danger">:message</p>') : '' !!}
            </div>

            <div class="profile-row">
                <h4>Email: </h4> <input id="email_input" type="text" name="email" value="{{ $data['email'] }}" readonly/>
                <a id="change_email" class="btn btn-default profile-left">
                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                    Change
                </a>
                <a id="save_email" class="btn btn-default profile-left">
                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                    Save Changes
                </a>
                {!! ($errors->has('email')) ? $errors->first('email', '<p class="text-danger">:message</p>') : '' !!}
            </div>

            <div class="profile-section">
                <h4>Change password: </h4>
                <div class="profile-row">
                    <h4>Old password: </h4> <input type="text" name="old_password"/>
                    {!! ($errors->has('old_password')) ? $errors->first('old_password', '<p class="text-danger">:message</p>') : '' !!}
                </div>

                <div class="profile-row">
                    <h4>New password: </h4> <input type="password" name="new_password"/>
                    {!! ($errors->has('new_password')) ? $errors->first('new_password', '<p class="text-danger">:message</p>') : '' !!}
                </div>

                <div class="profile-row">
                    <h4>Confirm new password: </h4> <input type="password" name="confirm_password"/>
                    {!! ($errors->has('confirm_password')) ? $errors->first('confirm_password', '<p class="text-danger">:message</p>') : '' !!}
                </div>
            </div>

            <div class="profile-section">
                <h4>Credit card information</h4>
                <div class="profile-row">
                    <h4>Credit card number: </h4> <input id="card_input" type="text" name="credit_card" value="{{ $data['credit_card'] }}" readonly/>
                    <a id="change_card" class="btn btn-default profile-left">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                        Change
                    </a>
                    <a id="save_card" class="btn btn-default profile-left">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                        Save Changes
                    </a>
                    {!! ($errors->has('credit_card')) ? $errors->first('credit_card', '<p class="text-danger">:message</p>') : '' !!}
                </div>

                <div class="profile-row">
                @if($data['credit_card'])
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
@stop

@push('script')
    <script type="text/javascript" src="{{ URL::asset('js/profile.js') }}"></script>
@endpush
