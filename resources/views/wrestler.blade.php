@extends('master')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <img src="{{ wrestlerImage($wrestler['image']['url']) }}" class="img-responsive" height="150" width="150" alt="{{ $wrestler['name'] }}">
                <p><strong>Age</strong></p>
                <p>{{ $wrestler['age'] }}</p>
                <p><strong>Gender</strong></p>
                <p>{{ $wrestler['gender'] }}</p>
                <p><strong>Height</strong></p>
                <p>{{ $wrestler['height'] }}</p>
                <p><strong>Weight</strong></p>
                <p>{{ $wrestler['weight'] }} lbs.</p>
            </div>
            <div class="col-md-10">
                <h2 class="page-header clearfix">
                    {{ $wrestler['name'] }}
                    @if (Auth::id() === $wrestler['id'])
                        <div class="pull-right">
                            <small><a href="{{ route('roster.wrestler.edit', ['wrestler' => $wrestler['slug']]) }}">Edit</a></small>
                        </div>
                    @endif
                </h2>
                <div>{!! $wrestler['bio'] !!}</div>
            </div>
        </div>
    </div>

@endsection