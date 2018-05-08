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
    Image path:
    <div class="number-box">
        <input type="text" class="form-control" name="image" placeholder="images/parking/" />
        {!! ($errors->has('image')) ? $errors->first('image', '<p class="text-danger">:message</p>') : '' !!}
    </div>
  </div>
  <div class="form-group">
    Enter working time:
    <div class="number-box">
        <input type="text" class="form-control time" name="working_time" /> : <input type="text" class="form-control time" name="working_time_two" />
        h -
        <input type="text" class="form-control time" name="working_time_three" /> : <input type="text" class="form-control time" name="working_time_four" /> h
    </div>
    {!! ($errors->has('working_time')) ? $errors->first('working_time', '<p class="text-danger">:message</p>') : '' !!}
    {!! ($errors->has('working_time_two')) ? $errors->first('working_time_two', '<p class="text-danger">:message</p>') : '' !!}
    {!! ($errors->has('working_time_three')) ? $errors->first('working_time_three', '<p class="text-danger">:message</p>') : '' !!}
    {!! ($errors->has('working_time_four')) ? $errors->first('working_time_four', '<p class="text-danger">:message</p>') : '' !!}
  </div>
  <div class="form-group">
    Enter price per hour:
    <div class="number-box">
        <input type="text" class="form-control prices" name="price_per_hour" maxlength="2" /> : <input type="text" class="form-control prices"  name="price_per_hour_two" maxlength="2" /> kn
    </div>
    {!! ($errors->has('price_per_hour')) ? $errors->first('price_per_hour', '<p class="text-danger">:message</p>') : '' !!}
    {!! ($errors->has('price_per_hour_two')) ? $errors->first('price_per_hour_two', '<p class="text-danger">:message</p>') : '' !!}
  </div>
  <div class="form-group">
    Enter price of reservation:
    <div class="number-box">
        <input type="text" class="form-control prices" name="price_of_reservation" maxlength="2"/> : <input type="text" class="form-control prices" name="price_of_reservation_two" maxlength="2" /> kn
    </div>
    {!! ($errors->has('price_of_reservation')) ? $errors->first('price_of_reservation', '<p class="text-danger">:message</p>') : '' !!}
    {!! ($errors->has('price_of_reservation_two')) ? $errors->first('price_of_reservation_two', '<p class="text-danger">:message</p>') : '' !!}
  </div>
  <div class="form-group">
    Enter price of reservation penalty:
    <div class="number-box">
        <input type="text" class="form-control prices" name="price_of_reservation_penalty" maxlength="2" /> : <input type="text" class="form-control prices" name="price_of_reservation_penalty_two" maxlength="2" /> kn
    </div>
    {!! ($errors->has('price_of_reservation_penalty')) ? $errors->first('price_of_reservation_penalty', '<p class="text-danger">:message</p>') : '' !!}
    {!! ($errors->has('price_of_reservation_penalty_two')) ? $errors->first('price_of_reservation_penalty_two', '<p class="text-danger">:message</p>') : '' !!}
  </div>
  {{ csrf_field() }}
  <input class="btn btn-lg btn-primary btn-block" type="submit" value="Create" />
</fieldset>
