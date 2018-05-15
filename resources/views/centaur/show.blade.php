@extends('Centaur::layout')

@section('title', 'Show')

@section('content')
    <div class="row dashboard">
        <div class="profile-row">
            <h1 class="text-center">{{ $info['title'] }}</h1>
        </div>
        <div class="profile-row">
            @foreach($info['data'] as $data)
                <table class="table">
                    <tr>
                        <td>
                            @if($info['id'] == 'city')
                                {{ $data->city }}
                            @elseif($info['id'] == 'parking')
                                {{ $data->name . ' (' . $data->city . ')'}}
                            @elseif($info['id'] == 'users')
                                {{ (Sentinel::getUser($data->user_id)->username) ? Sentinel::getUser($data->user_id)->username : Sentinel::getUser($data->user_id)->email }}
                                {{ ' (' . $info['lots']->find($data->parking_id)->name . ')'}}
                            @endif
                        </td>
                    </tr>
                </table>
            @endforeach
        </div>
    </div>
@stop
