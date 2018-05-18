@extends('Centaur::layout')

@section('title')
    {{ $parking->name }}
@endsection

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

@section('content')
    <div class="jumbotron">
        <div class="text-center">
            <h2>City: {{ $parking->city }}</h2>
            <h3>Parking lot: {{ $parking->name }}</h3>
            <h4>Address: {{ $parking->address }}</h4>
            <h4>Working time: {{ $parking->working_time }}</h4>
            <h4>Number of parking spots: {{ $parking->spots }}</h4>
            <h4>Price per hour: {{ $parking->price_per_hour }} kn/h</h4>
        </div>

        <div class="parking_map">
            <img class="img-responsive" src="{{ URL::asset($parking->image) }}" />
        </div>

        <div class="text-center spacing">
            <h4>Parking situation: </h4>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th>Parking spots taken</th>
                        <th>Parking spots reserved</th>
                        <th>Total parking spots</th>
                    </tr>

                    <tr>
                        <td>{{ $count['taken'] }}</td>
                        <td>{{ $count['reserved'] }}</td>
                        <td>{{ $parking->spots }}</td>
                    </tr>
                </table>
            </div>
        </div>

        @if (Sentinel::check())
            <div class="panel panel-default spacing">
                <div class="panel-heading"><h3>Reservation</h3></div>
                <div class="panel-body">
                    <h4>Price of reservation: {{ $parking->price_of_reservation }} kn</h4>
                    <h4>Duration of reservation: 25 minutes</h4>
                    <h4>Charge for missed reservation: {{ $parking->price_of_reservation_penalty }} kn</h4>
                    <h4>Time to cancel (get money refund): 5 minutes</h4>
                    <h4>Disabled usage of service after cancellation: 10 minutes</h4>

                    @if($reservation['code'] && $reservation['parking'] === $parking->id)
                        <h3>Your access code is: <span class="text-danger">{{ $reservation['code'] }}</span></h3>
                    @endif
                </div>
                <div class="panel-footer">
                    <form accept-charset="UTF-8" role="form" method="post" action="{{ route('view_forms', ['slug' => $parking->slug]) }}">
                        <button class="btn {{ ($has_reservation && $reservation['parking'] === $parking->id) ? 'btn-danger' : 'btn-primary' }} btn-lg" name="{{ ($has_reservation && $reservation['parking'] === $parking->id) ? 'reservation_true' : 'reservation' }}" type="submit">
                            {{ ($has_reservation && $reservation['parking'] === $parking->id) ? 'Cancel reservation' : 'Make reservation' }}
                        </button>
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        @endif
    </div>
@stop

@push('script')
    <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
@endpush
