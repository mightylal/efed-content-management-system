@extends('master')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center">{{ $event->name }}</h2>
            <p class="text-center">{{ $event->scheduled_at }}</p>
            <p class="text-center">{{ $event->preview }}</p>
            @if (count($segments) > 0)
                @foreach ($segments as $segment)
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="text-center">{{ $segment['name'] }}</h4>
                        </div>
                    </div>
                    @if (isset($segment['wrestlers']))
                        <div class="row">
                            <div class="col-md-12 text-center">
                            {!! $segment['wrestlers'] !!}
                            </div>
                        </div>
                    @endif
                    <div class="row" style="margin-top: 50px;">
                        <div class="col-md-12">
                            @if ($event->run || isset(Auth::user()->admin) ? Auth::user()->admin : false)
                                {!! $segment['result'] !!}
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

@endsection