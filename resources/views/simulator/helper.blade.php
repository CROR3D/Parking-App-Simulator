@extends('Centaur::layout')

@section('title', 'Helper')

@section('content')
    <div class="jumbotron">
        <div class="text-center">
            <h3 class="text-danger">PODATCI O PARKIRALIŠTU</h3>
            <h2>City: Zadar</h2>
            <h3>Parking lot: Foša</h3>
            <h4>Address: Ulica kralja Dmitra Zvonimira 2</h4>
            <h4>Working time: 08:00-16:00</h4>
            <h4>Number of parking spots: 50</h4>
            <h4>Price per hour: 4.00 kn/h</h4>
        </div>
    </div>

    <div class="jumbotron text-center">
        <h3 class="text-danger">TRENUTNA POZICIJA</h3>
        <h4 class="bg-primary">Plava boja označava gdje se trenutno nalazimo (na ulaznoj rampi trenutno)</h4>
        <nav class="position-helper" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="blue" data-rel="1">Entrance Barrier</li>
                <li data-rel="2">Parking</li>
                <li data-rel="3">Payment Device</li>
                <li data-rel="4">Exit Barrier</li>
            </ol>
        </nav>
    </div>

    <div class="jumbotron">
        <section class="parking-section">
            <div class="panel panel-default button-area text-center">
                <h3 class="text-danger">IZBORNIK KRETANJA</h3>
                <h4 class="bg-success">Zelena boja označava kretanje osobe pješice</h4>
                <h4 class="bg-info">Svijetlo plava boja označava kretanje osobe u vozilu</h4>
                <div class="helper">
                    <p>Access parking lot without getting a new ticket</p>
                    <button class="btn btn-md btn-success">Already Got Ticket</button>
                </div>
                <div class="helper">
                    <p>Access parking lot with vehicle</p>
                    <button class="btn btn-md btn-info">Enter Parking</button>
                </div>
            </div>

            <div class="panel panel-default service text-center">
                <h3 class="text-danger">PLOČA NA ULAZNOJ RAMPI</h3>
                <h4>Sastoji se od jednostavne tipkovnice za validiranje rezervacija i dugmeta za izbacivanje parkirne karte</h4>
                <h4>Fizička odsutnost karte u simulatoru se zamjenjuje ispisivanjem koda (koji možemo kopirati ili pogledati u bazu podataka njegovu vrijednost)</h4>
                <h3 class="text-center spacing-btm">Entrance service</h3>
                <div class="panel-body entrance_service">
                    <div class="panel panel-default numpad">
                        <div class="num-row">
                            <input id="screen" type="text" readonly/>
                        </div>
                        <div class="btn-group btn-group-justified" role="group" aria-label="...">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-default button">1</button>
                            </div>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-default button">2</button>
                            </div>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-default button">3</button>
                            </div>
                        </div>
                        <div class="btn-group btn-group-justified" role="group" aria-label="...">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-default button">4</button>
                            </div>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-default button">5</button>
                            </div>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-default button">6</button>
                            </div>
                        </div>
                        <h3>...</h3>
                    </div>

                    <div class="panel panel-default ticket-area text-center">
                        <input id="ticket-screen" type="text" readonly/>
                        <button class="btn btn-md btn-primary btn-ticket">Get Ticket</button>
                    </div>

                </div>
            </div>

            <div class="panel panel-default service text-center">
                <h3 class="text-danger">POGLED NA PARKIRALIŠTE</h3>
                <h4>Trenutna situacija (koju fizički vidimo)</h4>
                <h3 class="text-center spacing-btm">Parking lot view</h3>
                <div class="panel-body">
                    <h4 class="bg-primary">Tlocrt parkirališta koji nam prikazuje raspored parkirnih mjesta</h4>
                    <div class="text-center spacing">
                        <h4>Parking situation: </h4>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>Parking spots taken</th>
                                    <th>Total parking spots</th>
                                </tr>

                                <tr>
                                    <td>23</td>
                                    <td>55</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default service">
                <h3 class="text-danger text-center">UBRZAVANJE VREMENA</h3>
                <h4 class="bg-primary text-center">Ako želite preskočiti vrijeme na parkiralištu unesite vrijednosti</h4>
                <h4 class="bg-primary text-center">Pri ubacivanju karte u uređaj za plaćanje cijena će se izračunati ovisno o unesenim vrjednostima</h4>
                <div class="panel-body">
                    <div class="form-group middle">
                          Days:
                          <div class="time_input">
                              <input type="text" class="form-control time" maxlength="2"/>
                          </div>
                          Hours:
                          <div class="time_input">
                              <input type="text" class="form-control time" maxlength="2"/>
                          </div>
                          Minutes:
                          <div class="time_input">
                              <input type="text" class="form-control time" maxlength="2"/>
                          </div>
                    </div>
                    <div class="form-group middle">
                        Total time:
                        <input type="text" class="form-control total_time" readonly/>
                    </div>
                </div>
            </div>

            <div class="panel panel-default service">
                <h3 class="text-danger text-center">UREĐAJ ZA PLAĆANJE</h3>
                <h4 class="bg-primary text-center">Ubacivanje karte u uređaj simuliramo upisivanjem njenog koda na mjesto označeno plavom bojom</h4>
                <h4 class="bg-danger text-center">Nakon ubacivanja karte u uređaj na ekranu označenim crvenom bojom nam se prikazuje cijena koju trebamo platiti</h4>
                <h4 class="bg-success text-center">Ubacivanje novca u uređaj simuliramo upisivanjem količine kovanica na mjesto označeno zelenom bojom</h4>
                <h4 class="bg-info text-center">Ako ubacimo veću količinu kovanica od cijene karte ostatak nam se vraća na mjestu označenom svijetlo plavom bojom</h4>
                <h3 class="text-center spacing-btm">Payment device</h3>
                <div class="panel-body">
                    <div class="payment-device">
                        <div class="panel panel-primary">
                            <div class="row">
                                <input class="bg-danger" id="payment_screen" type="text"readonly/>
                            </div>

                            <div class="row">
                                <input class="bg-primary" id="insert_ticket" type="text" />
                            </div>
                            <button class="btn btn-primary btn-md">Accept ticket</button>

                            <div class="row">
                                <input class="bg-success" id="insert_coins" type="text"/>
                            </div>
                            <button class="btn btn-primary btn-md">Accept coins</button>

                            <div class="row">
                                <input class="bg-info" id="coin_refund" type="text" readonly/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default service">
                <h3 class="text-danger text-center">PLOČA NA IZLAZNOJ RAMPI</h3>
                <h4 class="text-center">Parkirna karta koju ubacujemo se validira i rampa se diže ovisno jesmo li ju uredno platili ili ne</h4>
                <h3 class="text-center spacing-btm">Exit service</h3>
                <div class="panel-body">
                    <div class="payment-device">
                        <div class="panel panel-primary">
                            <div class="row">
                                <input id="exit_insert_ticket" type="text" />
                            </div>
                            <button class="btn btn-primary btn-md">Accept ticket</button>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
@stop
