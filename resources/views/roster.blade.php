@extends('master')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>CHAMPIONS</h2>
            @if (count($champions) > 0)
                @for ($i = 0; $i < count($champions); $i++)
                    @if ($i == 0 || ($i % 2 == 1 && $i != 1))
                        <div class="row" style="margin-top: 10px;">
                    @endif
                    <div class="col-md-4 text-center">
                        <img class="img-responsive center-block" src="{{ defaultImage($champions[$i]->url) }}" alt="{{ $champions[$i]->titleName }}" width="150" height="150">
                        <h3>{{ $champions[$i]->titleName }}</h3>
                        @if ($champions[$i]->wrestlerOneName)
                            <p><a href="{{ route('roster.wrestler', ['wrestler' => $champions[$i]->wrestler_one_id]) }}">{{ $champions[$i]->wrestlerOneName }}</a></p>
                            @if ($champions[$i]->type == 'Tag Team')
                                <p><a href="{{ route('roster.wrestler', ['wrestler' => $champions[$i]->wrestler_two_id]) }}">{{ $champions[$i]->wrestlerTwoName }}</a></p>
                            @endif
                        @else
                            <p>Vacant</p>
                            @if ($champions[$i]->type == 'Tag Team')
                                <p>Vacant</p>
                            @endif
                        @endif
                    </div>
                    @if (($i % 2 == 0 && $i != 0) || (count($champions) - 1) == $i)
                    </div>
                    @endif
                @endfor
            @endif
            <h2>ROSTER</h2>
                @if ($wrestlers)
                    @for ($i = 0; $i < count($wrestlers); $i++)
                        @if ($i == 0 || ($i % 5 == 1 && $i != 1))
                        <div class="row" style="margin-top: 10px;">
                        @endif
                        <div class="col-md-2 text-center">
                            <img class="img-responsive center-block" src="{{ wrestlerImage($wrestlers[$i]['image']['url']) }}" width="100" height="100" alt="wrestler">
                            <h4><a href="{{ route('roster.wrestler', ['wrestler' => $wrestlers[$i]['slug']]) }}">{{ $wrestlers[$i]['name'] }}</a></h4>
                        </div>
                        @if (($i % 5 == 0 && $i != 0) || (count($wrestlers) - 1) == $i)
                        </div>
                        @endif
                    @endfor
                @endif
        </div>
    </div>
</div>

@endsection