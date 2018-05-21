@extends('Centaur::layout')

@section('title', 'View Messages')

@section('content')
    <div class="page-header">
        <h1>Messages</h1>
    </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                @if(!$messages->isEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Content</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($messages as $message)
                                    <tr>
                                        <td>{{ $message->title }}</td>
                                        <td>{{ str_limit($message->content, 40) }}</td>
                                        <td>
                                            <a href="{{ route('view_msg', $message->id) }}" class="btn btn-default" data-token="{{ csrf_token() }}">
                                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                                View
                                            </a>
                                            <a href="{{ route('delete_msg', $message->id) }}" class="btn btn-danger" data-method="delete" data-token="{{ csrf_token() }}">
                                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <h3 class="text-primary">No messages</h3>
                @endif
            </div>
        </div>
@stop
