@extends('Centaur::layout')

@section('title', 'Message')

@section('content')
    <div class="page-header">
        <h1>{{ $message->title }}</h1>
    </div>
    <div class="row">
        <p>{{ $message->content }}</p>
    </div>
@stop
