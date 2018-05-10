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
                <h4 class="text-left">Update parking lot individualy</h4>

                    @include('simulator.sub-views.select_form')

                    <button class="btn btn-lg btn-primary btn-ticket" name="select" value="" type="submit">
                        Update Parking
                    </button>
            </div>
        </div>
        <div class="row select-form">
            <div class="col-md-6 tutorial">
                <h4 class="text-left">Update all parking lots in one city</h4>
                <div class="form-group text-left">
                    <label for="select3">Select City</label>
                        <select class="form-control" name="select_only_city" id="select3">
                            <option>---</option>
                            @foreach($city_list as $city)
                                  <option class="dropdown-item" value="{{ $city_values[$city->city] }}">{{ $city->city }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-lg btn-primary btn-ticket" name="select_all" value="" type="submit">
                            Update City Lots
                        </button>
                </div>
            </div>
        </div>
    </form>
</div>
@stop

@push('script')
    <script type="text/javascript" src="{{ URL::asset('js/dropdown.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/dropdown_update.js') }}"></script>
@endpush
