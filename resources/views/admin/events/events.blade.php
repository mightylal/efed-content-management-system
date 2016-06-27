@extends('master')

@section('content')

<div class="container">
    @include('admin.events.events_menu')
    <div class="row">
        <div class="col-md-12">
            <h2>BOOK EVENT</h2>
            <form action="{{ url('admin/events') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                </div>
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" class="form-control" name="scheduled_at" id="date" placeholder="mm/dd/yyyy">
                </div>
                <div class="form-group">
                    <label for="deadline">Roleplay Deadline</label>
                    <input type="date" class="form-control" name="deadline_at" id="deadline" placeholder="mm/dd/yyyy">
                </div>
                <div class="form-group">
                    <label for="preview">Preview</label>
                    <textarea class="form-control" name="preview" id="preview" placeholder="Preview" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Create</button>    
                </div>
            </form>
            <h2>EVENTS</h2>
            @if (!empty($events))
            <form action="{{ route('admin.events') }}" method="POST">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
            @endif
            <table class="table table-striped">
                <thead>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Cancel</th>
                </thead>
                <tbody>
                    @if (count($events) > 0)
                        @foreach ($events as $event)
                            <tr>
                                <td><a href="{{ url('admin/events/' . $event['id'] . '/edit') }}">{{ $event['name'] }}</a></td>
                                <td>{{ $event['scheduled_at'] }}</td>
                                <td><input type="checkbox" name="id[{{ $event['id'] }}]" value="{{ $event['id'] }}"></td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td>There are no events. Create one by clicking on the "Book Event" tab.</td></tr>
                    @endif
                </tbody>
            </table>
            @if (!empty($events))
            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary">Delete</button>
            </div>
            </form>
            @endif
        </div>
    </div>
</div>

@endsection