@extends('master')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>EVENTS</h2>
            <table class="table table-striped">
                <thead>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Roleplay Deadline</th>
                </thead>
                <tbody>
                    @if (!empty($events))
                        @foreach ($events as $event)
                        <tr>
                            <td><a href="{{ url('events/' . $event['id']) }}">{{ $event['name'] }}</a></td>
                            <td>{{ $event['scheduled_at'] }}</td>
                            @if (time() > strtotime($event['deadline_at']))
                            <td>Passed</td>
                            @else
                            <td>{{--In {{ $date->diffForHumans($date->createFromFormat('Y-m-d H:i:s', $event->deadline), true) }} --}}</td>
                                <td>{{ $event['deadline_at'] }}</td>
                            @endif
                        </tr>
                        @endforeach
                    @else
                        <tr><td>There are no events.</td></tr>
                    @endif
                </tbody>
            </table>
            {{--{!! $events->render() !!}--}}
        </div>
    </div>
</div>

@endsection