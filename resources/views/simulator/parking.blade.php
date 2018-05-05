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
        <nav class="position-helper" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="{{ ($status['entrance'] < 3) ? 'blue' : ''}}"data-rel="1">Entrance Barrier</li>
                <li class="{{ ($status['entrance'] == 3) ? 'blue' : ''}}" data-rel="2">Parking</li>
                <li class="{{ ($status['entrance'] == 4) ? 'blue' : ''}}"data-rel="3">Payment Device</li>
                <li class="{{ ($status['entrance'] == 5) ? 'blue' : ''}}"data-rel="4">Exit Barrier</li>
            </ol>
        </nav>
    </div>

    <div class="jumbotron">
            <section class="parking-section">
                <form accept-charset="UTF-8" role="form" method="post" action="{{ route('simulator_forms', ['slug' => $parking->slug]) }}">
                {{ csrf_field() }}

                    <div class="panel panel-default button-area text-center">
                        <h3 class="text-center spacing-btm">Movement helper</h3>
                        @if($status['entrance'] <= 2)
                            <div class="helper">
                                <p>Access parking lot without getting a new ticket</p>
                                <button class="btn btn-md btn-info" name="already_got_ticket" type="submit" {{ ($status['entrance'] == 2) ? 'disabled' : ''}}>Already Got Ticket</button>
                            </div>
                            <div class="helper">
                                <p>Access parking lot with vehicle</p>
                                <button class="btn btn-md btn-success" name="green" type="submit" {{ ($status['entrance'] < 2) ? 'disabled' : ''}}>Enter Parking</button>
                            </div>
                        @elseif($status['entrance'] == 3)
                            <div class="helper">
                                <p>Pay the ticket</p>
                                <button class="btn btn-info btn-md" name="payment" type="submit">Payment device</button>
                            </div>
                            <div class="helper">
                                <p>Leave parking lot</p>
                                <button class="btn btn-success btn-md" name="go_to_exit" type="submit">Go towards exit</button>
                            </div>
                        @elseif($status['entrance'] == 4)
                            <div class="helper">
                                <p>Go back to the parking area</p>
                                <button class="btn btn-info btn-md" name="back_to_parking" type="submit">Parking area</button>
                            </div>
                            <div class="helper">
                                <p>Leave parking lot</p>
                                <button class="btn btn-success btn-md" name="go_to_exit" type="submit">Go towards exit</button>
                            </div>
                        @elseif($status['entrance'] == 5)
                            <div class="helper">
                                <p>Go back to the parking area</p>
                                <button class="btn btn-info btn-md" name="back_to_parking" type="submit">Parking area</button>
                            </div>
                            <div class="helper">
                                <p>Pay the ticket</p>
                                <button class="btn btn-info btn-md" name="payment" type="submit">Payment device</button>
                            </div>
                        @endif
                    </div>

        @if($status['entrance'] < 3)
                    <div class="panel panel-default service">
                        <h3 class="text-center spacing-btm">Entrance service</h3>
                        <div class="panel-body">
                            <div class="panel panel-default numpad">
                                @include('simulator.sub-views.numpad')
                            </div>

                            <div class="panel panel-default ticket-area text-center">
                                <input id="ticket-screen" type="text" name="display_ticket" value="{{ $status['value'] }}" readonly/>
                                <button class="btn btn-md btn-primary btn-ticket" name="ticket" type="submit" {{ ($status['entrance'] == 2) ? 'disabled' : ''}}>Get Ticket</button>
                            </div>

                        </div>
                    </div>

        @elseif($status['entrance'] == 3)

                    <div class="panel panel-default service">
                        <h3 class="text-center spacing-btm">Parking lot view</h3>
                        <div class="panel-body">
                            <div class="parking_map">
                                <img class="img-responsive" src="{{ URL::asset('images/zagreb-centar-2.jpg') }}" />
                            </div>

                            <div class="text-center spacing">
                                <h4>Parking situation: </h4>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th>Parking spots taken</th>
                                            <th>Total parking spots</th>
                                        </tr>

                                        <tr>
                                            <td>{{ $count['taken'] }}</td>
                                            <td>{{ $parking->spots }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

        @elseif($status['entrance'] == 4)
                    <div class="panel panel-default service">
                        <h3 class="text-center spacing-btm">Payment device</h3>
                        <div class="panel-body">
                            <div class="payment-device">
                                <div class="panel panel-primary">
                                    <div class="row">
                                        <input id="payment_screen" type="text" name="payment_screen" value="{{ ($ticket['price'] == 0) ? '' : $ticket['price'] }}" readonly/>
                                    </div>

                                    <div class="row">
                                        <input id="insert_ticket" type="text" name="insert_ticket" placeholder="Insert ticket" value="{{ ($ticket_check) ? $ticket_check : '' }}" {{ ($ticket_check) ? 'readonly' : '' }}/>
                                    </div>
                                    <button class="btn btn-primary btn-md" name="submit_ticket" type="submit" {{ ($ticket['price'] == 0) ? '' : 'disabled' }}>Accept ticket</button>

                                    <div class="row">
                                        <input id="insert_coins" type="text" name="insert_coins" placeholder="Insert coins" value="" />
                                    </div>
                                    <button class="btn btn-primary btn-md" name="submit_coins" type="submit" {{ ($ticket['price'] == 0) ? 'disabled' : '' }}>Accept coins</button>

                                    <div class="row">
                                        <input id="coin_refund" type="text" name="coin_refund" placeholder="Coin refund" value="{{ ($ticket['refund'] == 0) ? '' : $ticket['refund'] }}" readonly/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        @endif

            </form>
        </section>
    </div>
@stop

@push('script')
    <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ URL::asset('js/calculator.js') }}"></script>
@endpush
