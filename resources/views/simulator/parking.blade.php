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
    </div>
@stop

@push('script')
    <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
@endpush
