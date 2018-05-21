@extends('Centaur::layout')

@section('title', 'Write Message')

@section('content')
<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Make an notification for all users</h3>
      </div>
      <div class="panel-body">
        <form accept-charset="UTF-8" role="form" method="post" action="">
            <fieldset>
              <div class="form-group">
                <input type="text" class="form-control" name="title" placeholder="Enter title" value="" />
                {!! ($errors->has('title')) ? $errors->first('title', '<p class="text-danger">:message</p>') : '' !!}
              </div>
              <div class="form-group">
                <textarea type="text" class="form-control" name="content" placeholder="Write message text" style="height:400px;"></textarea>
                {!! ($errors->has('content')) ? $errors->first('content', '<p class="text-danger">:message</p>') : '' !!}
              </div>
              {{ csrf_field() }}
              <input class="btn btn-lg btn-primary btn-block" type="submit" value="Send" />
            </fieldset>
        </form>
      </div>
    </div>
  </div>
</div>
@stop
