@extends('master')

@section('content')

<div class="container">
    @include('admin.events.events_menu')
    <div class="row">
        <div class="col-md-12">
            <h2>BOOK SEGMENT</h2>
            <form action="{{ route('admin.events.segment.create') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                </div>
                <div class="form-group">
                    <label for="event">Event</label>
                    <select name="event_id" id="event" class="form-control">
                        @if (is_array($events))
                            @foreach ($events as $event)
                                <option value="{{ $event['id'] }}">{{ $event['name'] }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <div id="wrestlerOptions" class="hidden">
                        @if (!empty($wrestlers))
                            @foreach ($wrestlers as $wrestler)
                                <option value="{{ $wrestler['id'] }}">{{ $wrestler['name'] }}</option>
                            @endforeach
                        @endif
                    </div>
                    <label for="type">Type</label>
                    <select name="type" id="type" class="form-control">
                        <option value="1v1">1 vs. 1</option>
                        <option value="1v1v1">1 vs. 1 vs. 1</option>
                        <option value="1v1v1v1">1 vs. 1 vs. 1 vs. 1</option>
                        <option value="1v1v1v1v1">1 vs. 1 vs. 1 vs. 1 vs. 1</option>
                        <option value="1v1v1v1v1v1">1 vs. 1 vs. 1 vs. 1 vs. 1 vs. 1</option>
                        <option value="2v2">2 vs. 2</option>
                        <option value="2v2v2">2 vs. 2 vs. 2</option>
                        <option value="2v2v2v2">2 vs. 2 vs. 2 vs. 2</option>
                        <option value="3v3">3 vs. 3</option>
                        <option value="4v4">4 vs. 4</option>
                        <option value="5v5">5 vs. 5</option>
                        <option value="2v1">2 vs. 1</option>
                        <option value="3v2">3 vs. 2</option>
                        <option value="10">10 Man Battle Royal</option>
                        <option value="20">20 Man Battle Royal</option>
                        <option value="30">30 Man Battle Royal</option>
                        <option value="0">Angle</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="wrestlers-container">Wrestlers</label>
                    <div id="wrestlers-container">
                        <select name="wrestler[]" class="form-control">
                            {{--!! $wrestlerOptions !!}--}}
                            @if (!empty($wrestlers))
                                @foreach ($wrestlers as $wrestler)
                                    <option value="{{ $wrestler['id'] }}">{{ $wrestler['name'] }}</option>
                                @endforeach
                            @endif
                        </select>
                        <p class="help-block">VS.</p>
                        <select name="wrestler[]" class="form-control">
                            {{--{!! $wrestlerOptions !!}--}}
                            @if (!empty($wrestlers))
                                @foreach ($wrestlers as $wrestler)
                                    <option value="{{ $wrestler['id'] }}">{{ $wrestler['name'] }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')

    <script src="{{ asset('js/segment.js') }}"></script>

@endsection