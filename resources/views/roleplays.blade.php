@extends('master')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>ROLEPLAYS</h2>
            <table class="table table-striped">
                <thead>
                    <th>Title</th>
                    <th>Wrestler</th>
                    <th>Event</th>
                    <th>Grade</th>
                </thead>
                <tbody>
                    @if (count($roleplays) > 0)
                        @foreach ($roleplays as $roleplay)
                            <tr>
                                <td><a href="{{ url('roleplays/' . $roleplay->id) }}">{{ $roleplay->name }}</a></td>
                                <td><a href="{{ url('wrestlers/' . $roleplay->wrestler->id) }}">{{ $roleplay->wrestler->name }}</a></td>
                                @if ($roleplay->event)
                                    <td><a href="{{ url('event/' . $roleplay->event->id) }}">{{ $roleplay->event->name }}</a></td>
                                @else
                                    <td>deleted</td>
                                @endif
                                <td>{{ $roleplay->fed_score }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td>There are no roleplays.</td></tr>
                    @endif
                </tbody>
            </table>
            <div class="text-right">
            {!! $roleplays->render() !!}
            </div>
        </div>
    </div>
</div>

@endsection