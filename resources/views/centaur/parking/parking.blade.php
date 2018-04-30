@extends('Centaur::layout')

@section('title')
    {{ $parking->name }}
@endsection

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

@section('content')
    <div class="jumbotron">
        <div class="text-center">
            <h2>Grad: {{ $parking->city }}</h2>
            <h3>Parkiralište: {{ $parking->name }}</h3>
            <h4>Adresa: {{ $parking->address }}</h4>
            <h4>Radno vrijeme: {{ $parking->working_time }}</h4>
            <h4>Broj parkirnih mjesta: {{ $parking->spots }}</h4>
            <h4>Cijena po satu: {{ $parking->price_per_hour }} kn/h</h4>
        </div>

        <div class="parking_map">
            <img class="img-responsive" src="{{ URL::asset('images/zagreb-centar-2.jpg') }}" />
        </div>

        <div class="text-center spacing">
            <h4>Stanje na parkingu: </h4>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th>Zauzeto mjesta</th>
                        <th>Rezervirano mjesta</th>
                        <th>Ukupno mjesta</th>
                    </tr>

                    <tr>
                        <td>{{ $count['taken'] }}</td>
                        <td>{{ $count['reserved'] }}</td>
                        <td>{{ $parking->spots }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="panel panel-default spacing">
            <div class="panel-heading"><h3>Rezervacija</h3></div>
            <div class="panel-body">
                <h4>Cijena za rezervaciju: {{ $parking->price_of_reservation }} kn</h4>
                <h4>Trajanje rezervacije: 25 minuta</h4>
                <h4>Naknada za propuštenu rezervaciju: {{ $parking->price_of_reservation_penalty }} kn</h4>
                <h4>Vrijeme za otkazivanje: 5 minuta</h4>
                <h4>Onemogućeno korištenje rezervacije nakon otkazivanja: 10 minuta</h4>
            </div>
            <div class="panel-footer">
                <form accept-charset="UTF-8" role="form" method="post" action="{{ route('simulator_forms', ['slug' => $parking->slug]) }}">
                    <button class="btn {{ ($has_reservation) ? 'btn-danger' : 'btn-primary' }} btn-lg" name="{{ ($has_reservation) ? 'reservation_true' : 'reservation' }}" type="submit">
                        {{ ($has_reservation) ? 'Otkaži Rezervaciju' : 'Rezerviraj Mjesto' }}
                    </button>
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
@stop

@push('script')
    <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
@endpush
