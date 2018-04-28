@extends('Centaur::layout')

@section('title', 'Create New Parking Lot')

@push('tinymce')
  <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
  <script>tinymce.init({ selector:'textarea' });</script>
@endpush

@section('content')
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title">Create New Parking Lot</h3>
          </div>
          <div class="panel-body">
            <form accept-charset="UTF-8" role="form" method="post" action="{{ route('create') }}">
              <fieldset>
                <div class="form-group">
                  <input type="text" class="form-control" name="city" placeholder="Enter city" />
                  {!! ($errors->has('city')) ? $errors->first('city', '<p class="text-danger">:message</p>') : '' !!}
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="name" placeholder="Enter name" />
                  {!! ($errors->has('name')) ? $errors->first('name', '<p class="text-danger">:message</p>') : '' !!}
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="address" placeholder="Enter address" />
                  {!! ($errors->has('address')) ? $errors->first('address', '<p class="text-danger">:message</p>') : '' !!}
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="spots" placeholder="Enter number of spots" />
                  {!! ($errors->has('spots')) ? $errors->first('spots', '<p class="text-danger">:message</p>') : '' !!}
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="working_time" placeholder="Enter working time" />
                  {!! ($errors->has('working_time')) ? $errors->first('working_time', '<p class="text-danger">:message</p>') : '' !!}
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="price_per_hour" placeholder="Enter price per hour" />
                  {!! ($errors->has('price_per_hour')) ? $errors->first('price_per_hour', '<p class="text-danger">:message</p>') : '' !!}
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="price_of_reservation" placeholder="Enter price of reservation" />
                  {!! ($errors->has('price_of_reservation')) ? $errors->first('price_of_reservation', '<p class="text-danger">:message</p>') : '' !!}
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="price_of_reservation_penalty" placeholder="Enter price of reservation penalty" />
                  {!! ($errors->has('price_of_reservation_penalty')) ? $errors->first('price_of_reservation_penalty', '<p class="text-danger">:message</p>') : '' !!}
                </div>
                {{ csrf_field() }}
                <input class="btn btn-lg btn-primary btn-block" type="submit" value="Create" />
              </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
@stop
