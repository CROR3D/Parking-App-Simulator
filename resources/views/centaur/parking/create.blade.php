@extends('Centaur::layout')

@section('title', 'Create New Parking Lot')

@push('custom-css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/layout.css') }}">
@endpush

@section('content')
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title">Create New Parking Lot</h3>
          </div>
          <div class="panel-body">
            <form accept-charset="UTF-8" role="form" method="post" action="{{ route('create') }}">
                @include('centaur.parking.sub-views.parking_form')
            </form>
          </div>
        </div>
      </div>
    </div>
@stop

@push('script')
  <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
  <script>tinymce.init({ selector:'textarea' });</script>
@endpush
