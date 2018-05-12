@extends('Centaur::layout')

@section('title', 'Update Parking Lot')

@push('custom-css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/create.css') }}">
@endpush

@section('content')
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title">Update {{ ucfirst($city) }} Parking Lot Information</h3>
          </div>
          <div class="panel-body">
            <form accept-charset="UTF-8" role="form" method="post" action="{{ route('update_city_form', ['city' => $city]) }}">
                <fieldset>
                    <label class="text-info">Set time (default)</label>
                     <div class="form-group">
                         <label for="select3">Change working time</label>
                         <div class="form-group text-left">
                             <div id="working_time" class="box">
                                 <input class="checkbox-group" type="checkbox" name="add_time" value=""> Add time <input class="checkbox-group" type="checkbox" name="subtract_time" value=""> Subtract time<br>
                                 <div class="number-box">
                                     <input type="text" class="form-control time" name="start_hour" value="" /> : <input type="text" class="form-control time" name="start_minute" value="" />
                                      h -
                                     <input type="text" class="form-control time" name="close_hour" value="" /> : <input type="text" class="form-control time" name="close_minute" value="" /> h
                                </div>
                             </div>
                         </div>
                     </div>

                     <label class="text-info">Decrease prices (default)</label>

                     <div class="form-group">
                         <div class="form-group text-left">
                             <label for="select3">Change price per hour</label>
                             <div class="form-group">
                                 <input type="checkbox" name="add_price" value=""> Increase prices per hour<br>
                             </div>
                             <div class="number-box">
                                 <input type="text" class="form-control prices" name="price_one" maxlength="2" value="" /> : <input type="text" class="form-control prices"  name="price_two" maxlength="2" value=""/> kn
                             </div>
                         </div>
                     </div>

                     <div class="form-group">
                         <div class="form-group text-left">
                             <label for="select3">Change reservation prices</label>
                             <div class="form-group">
                                 <input type="checkbox" name="add_reservation" value=""> Increase reservation prices<br>
                             </div>
                             <div class="number-box">
                                 <input type="text" class="form-control prices" name="reservation_one" maxlength="2" value="" /> : <input type="text" class="form-control prices"  name="reservation_two" maxlength="2" value=""/> kn
                             </div>
                         </div>
                     </div>

                     <div class="form-group">
                         <div class="form-group text-left">
                             <label for="select3">Change penalty prices</label>
                             <div class="form-group">
                                 <input type="checkbox" name="add_penalty" value=""> Increase penalty prices<br>
                             </div>
                             <div class="number-box">
                                 <input type="text" class="form-control prices" name="penalty_one" maxlength="2" value="" /> : <input type="text" class="form-control prices"  name="penalty_two" maxlength="2" value=""/> kn
                             </div>
                         </div>
                     </div>
                  {{ csrf_field() }}
                  <input class="btn btn-lg btn-primary btn-block" type="submit" value="Update" />
                </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
@stop

@push('script')
    <script type="text/javascript" src="{{ URL::asset('js/update_city.js') }}"></script>
  <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
  <script>tinymce.init({ selector:'textarea' });</script>
@endpush
