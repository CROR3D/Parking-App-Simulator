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
            <form accept-charset="UTF-8" role="form" method="post" action="">
                <fieldset>
                    <label class="text-info">Set time (default)</label>
                     <div class="form-group">
                         <div class="form-group text-left">
                             <label for="select3">Change working time</label>
                                 <select id="selectTime" class="form-control" name="">
                                    <option class="dropdown-item" value="starting_time">Change starting time</option>
                                    <option class="dropdown-item" value="closing_time">Change closing time</option>
                                    <option class="dropdown-item" value="working_time">Change working time</option>
                                 </select>
                         </div>
                         <div class="form-group text-left">
                             <div id="starting_time" class="box">
                                 <input type="checkbox" name="add_starting_time" value=""> Add time <input type="checkbox" name="subtract_starting_time" value=""> Subtract time<br>
                                 <div class="number-box">
                                     <input type="text" class="form-control time" name="" value="" /> : <input type="text" class="form-control time" name="" value="" /> h
                                </div>
                             </div>
                             <div id="closing_time" class="box">
                                 <input type="checkbox" name="add_closing_time" value=""> Add time <input type="checkbox" name="subtract_closing_time" value=""> Subtract time<br>
                                 <div class="number-box">
                                     <input type="text" class="form-control time" name="" value="" /> : <input type="text" class="form-control time" name="" value="" /> h
                                </div>
                             </div>
                             <div id="working_time" class="box">
                                 <div class="number-box">
                                     <input type="text" class="form-control time" name="" value="" /> : <input type="text" class="form-control time" name="" value="" />
                                      h -
                                     <input type="text" class="form-control time" name="" value="" /> : <input type="text" class="form-control time" name="" value="" /> h
                                </div>
                             </div>
                         </div>
                     </div>

                     <label class="text-info">Decrease prices (default)</label>

                     <div class="form-group">
                         <div class="form-group text-left">
                             <label for="select3">Change price per hour</label>
                             <div class="form-group">
                                 <input type="checkbox" name="add_price_per_hour" value=""> Increase prices per hour<br>
                             </div>
                             <div class="number-box">
                                 <input type="text" class="form-control prices" name="" maxlength="2" value="" /> : <input type="text" class="form-control prices"  name="" maxlength="2" value=""/> kn
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
                                 <input type="text" class="form-control prices" name="" maxlength="2" value="" /> : <input type="text" class="form-control prices"  name="" maxlength="2" value=""/> kn
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
                                 <input type="text" class="form-control prices" name="" maxlength="2" value="" /> : <input type="text" class="form-control prices"  name="" maxlength="2" value=""/> kn
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
