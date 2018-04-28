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

    <div class="row">
        <div class="jumbotron text-center">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="{{ ($status['entrance'] < 3) ? 'blue' : ''}}"data-rel="1">Entrance Ramp</li>
                    <li class="{{ ($status['entrance'] == 3) ? 'blue' : ''}}" data-rel="2">Parking</li>
                    <li class="{{ ($status['entrance'] == 4) ? 'blue' : ''}}"data-rel="3">Payment Device</li>
                    <li class="{{ ($status['entrance'] == 5) ? 'blue' : ''}}"data-rel="4">Exit Ramp</li>
                </ol>
            </nav>

            @if($status['entrance'] < 3)
            <section class="parking-section">
                
            </section>

            @elseif($status['entrance'] == 3)
                <section class="parking-section">

                </section>

            @elseif($status['entrance'] == 4)
                <section class="parking-section">

                </section>

            @elseif($status['entrance'] == 5)
                <section class="parking-section">

                </section>
            @endif
        </div>
    </div>
    </div>
@stop

@push('script')
    <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ URL::asset('js/calculator.js') }}"></script>
@endpush
