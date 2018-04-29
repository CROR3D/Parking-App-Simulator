@extends('Centaur::layout')

@section('title', 'Select Parking')

@push('custom-css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/select.css') }}">
@endpush

<!-- LOGIRANI TREBAJU IMATI DRUGAČIJU RUTU ZA VIEW PARKING OD SIMULATORA -->

@section('content')
<div class="jumbotron">
    <h2 class="title">Parking Simulator</h2>
    <div class="row select-form">
        <div class="col-md-6">
            <form accept-charset="UTF-8" role="form" method="post" action="{{ route('post_simulator', ['slug' => 'parking']) }}">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="select1">Select City</label>
                        <select class="form-control" name="select_city" id="select1">
                            <option>---</option>
                            @foreach($city_list as $city)
                                  <option class="dropdown-item" value="{{ $city_values[$city->city] }}">{{ $city->city }}</option>
                            @endforeach
                        </select>
                </div>

                <div class="form-group">
                    <label for="select2">Select Parking</label>
                        <select class="form-control" name="select_parking" id="select2" disabled>
                            <option>---</option>
                            @foreach($parking_list as $parking)
                                  <option name="{{ $parking->slug }}" class="dropdown-item" value="{{ $parking_values[$parking->slug] }}">{{ $parking->name }}</option>
                            @endforeach
                        </select>
                </div>
                <button class="btn btn-lg btn-primary btn-ticket" name="select" value="" type="submit">
                    @if(Sentinel::check())
                        View Parking
                    @else
                        Enter Parking
                    @endif
                </button>
            </form>
        </div>
    </div>
</div>
@stop

@push('script')
    <script>
        $(window).on('load', function() {
            $("#select1").val('---');
            $("#select2").val('---');
        });

        $("#select1").click(function(event) {
            event.preventDefault();
            if($(this).val() == '---'){
                $('#select2').prop("disabled", true);
            } else {
                $('#select2').prop("disabled", false);
            }
        });

        $("#select1").change(function() {
            if ($(this).data('options') === undefined) {
                $(this).data('options', $('#select2 option').clone());
            }
            var id = $(this).val();
            var options = $(this).data('options').filter('[value=' + id + ']');
            $('#select2').html(options).change();
        });

        $("#select2").change(function() {
            var slug = $('#select2').find(':selected').attr('name');
            $('button[name=select]').val(slug);
        });
    </script>
@endpush
