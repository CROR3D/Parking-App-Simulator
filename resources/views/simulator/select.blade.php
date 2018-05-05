@extends('Centaur::layout')

@section('title', 'Select Parking')

@push('custom-css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/select.css') }}">
@endpush

@section('content')
<div class="jumbotron">
    <h2 class="title">Parking Simulator</h2>
    <div class="row select-form">
        <div class="col-md-6">
            <form accept-charset="UTF-8" role="form" method="post" action="{{ route('post_simulator', ['slug' => 'parking']) }}">
                {{ csrf_field() }}

                @include('simulator.sub-views.select_form')

                <button class="btn btn-lg btn-primary btn-ticket" name="select" value="" type="submit">
                    Enter Parking
                </button>
            </form>
        </div>

        <div class="col-md-offset-2 col-md-4 tutorial">
            <h4>Check helper for parking simulator</h4>
            <a class="btn btn-block btn-info" href="{{ route('simulator_help') }}">HELP</a>
        </div>
    </div>
</div>
@stop

@push('script')
    <script type="text/javascript" src="{{ URL::asset('js/dropdown.js') }}"></script>
@endpush
