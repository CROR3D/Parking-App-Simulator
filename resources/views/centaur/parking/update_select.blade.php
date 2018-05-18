@extends('Centaur::layout')

@section('title', 'Select Parking')

@push('custom-css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/select.css') }}">
@endpush

@section('content')
<div class="jumbotron">
    <form accept-charset="UTF-8" role="form" method="post" action="{{ route('update_select') }}">
        {{ csrf_field() }}
        <h2 class="title">Parking Update</h2>
        <div class="row select-form">
            <div class="col-md-6">
                <h4 class="text-left">Update parking lot individually</h4>

                    @include('simulator.sub-views.select_form')

                    <button class="btn btn-lg btn-primary btn-ticket" name="select" value="" type="submit">
                        Update Parking
                    </button>
            </div>
        </div>
    </form>
</div>
@stop

@push('script')
    <script type="text/javascript" src="{{ URL::asset('js/dropdown.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/dropdown_update.js') }}"></script>
@endpush
