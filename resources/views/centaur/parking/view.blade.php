@extends('Centaur::layout')

@section('title', 'Select Parking')

@push('custom-css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/select.css') }}">
@endpush

@section('content')
<div class="jumbotron">
    <h2 class="title">Parking View</h2>
    <div class="row select-form">
        <div class="col-md-6">
            <form accept-charset="UTF-8" role="form" method="post" action="{{ route('view_form', ['slug' => 'parking']) }}">
                {{ csrf_field() }}

                @include('simulator.sub-views.select_form')

                <button class="btn btn-lg btn-primary btn-ticket" name="select" value="" type="submit">
                    View Parking
                </button>
            </form>
        </div>
    </div>
</div>
@stop

@push('script')
    @include('simulator.sub-views.dropdown_script')
@endpush
