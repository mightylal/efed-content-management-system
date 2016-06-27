@extends('master')

@section('content')

<div class="container">
    @include('admin.events.events_menu')
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin.events.run', ['id' => $event['id']]) }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="event" value="{{ $event['id'] }}">
                <h2>MANAGE EVENT <button type="submit" class="btn btn-primary btn-xs">Run</button></h2>
            </form>
            <form action="{{ route('admin.events.edit', ['id' => $event['id']]) }}" method="POST">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Name</label>
                    {!! Form::text('name', e($event['name']), ['class' => 'form-control', 'id' => 'name']) !!}
                </div>
                <div class="form-group">
                    <label for="date">Date</label>
                    {!! Form::input('date', 'scheduled_at', date('Y-m-d', strtotime($event['scheduled_at'])), ['class' => 'form-control', 'id' => 'date']) !!}
                </div>
                <div class="form-group">
                    <label for="preview">Preview</label>
                    {!! Form::textarea('preview', $event['preview'], ['class' => 'form-control', 'id' => 'preview', 'rows' => 3]) !!}
                </div>
                <table class="table table-striped">
                    <thead>
                        <th>Segment</th>
                        <th>Ready</th>
                        <th>Placement</th>
                    </thead>
                    <tbody id="sortable">
                    @if (count($segments) > 0)
                        @foreach ($segments as $segment)
                            <tr class="ui-state-default">
                                <input type="hidden" name="id[]" value="{{ $segment['id'] }}">
                                <td><a href="{{ route('admin.events.segment.edit', ['id' => $event['id'], 'segment_id' => $segment['id']]) }}">{{ $segment['name'] }}</a></td>
                                <td>
                                    @if ($segment['publish'])
                                    Yes
                                    @else
                                    No
                                    @endif
                                </td>    
                                <td>{{ $segment['placement'] }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td>There are no segments. Create one by clicking on the "Book Segment" tab.</td></tr>
                    @endif
                    </tbody>
                </table>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection