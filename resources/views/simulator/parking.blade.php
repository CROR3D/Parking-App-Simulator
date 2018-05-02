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
    </div>

    <div class="jumbotron text-center">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="{{ ($status['entrance'] < 3) ? 'blue' : ''}}"data-rel="1">Entrance Barrier</li>
                <li class="{{ ($status['entrance'] == 3) ? 'blue' : ''}}" data-rel="2">Parking</li>
                <li class="{{ ($status['entrance'] == 4) ? 'blue' : ''}}"data-rel="3">Payment Device</li>
                <li class="{{ ($status['entrance'] == 5) ? 'blue' : ''}}"data-rel="4">Exit Barrier</li>
            </ol>
        </nav>

        <div class="position-helper">
            <img class="img-responsive" src="{{ URL::asset('images/barrier.png') }}"/>
        </div>
    </div>

    <div class="jumbotron">
        @if($status['entrance'] < 3)
            <section class="parking-section">
                <h4 class="text-center spacing-btm">Entrance service</h4>
                <form accept-charset="UTF-8" role="form" method="post" action="{{ route('simulator_forms', ['slug' => $parking->slug]) }}">
                {{ csrf_field() }}

                    <div class="panel panel-primary service">
                        <div class="panel-body">
                            @include('simulator.sub-views.numpad');
                        </div>
                    </div>

                </form>
            </section>
        @endif
    </div>
@stop

@push('script')
    <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ URL::asset('js/calculator.js') }}"></script>
@endpush
