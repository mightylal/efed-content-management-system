@extends('master')

@section('content')

<div class="container">
    @include('admin.events.events_menu')
    <div class="row">
        <div class="col-md-12">
            <p><a href="{{ route('admin.events.edit', ['id' => $segment['event_id']]) }}">Back to event</a></p>
            <form action="{{ route('admin.events.segment.edit', ['id' => $segment['event_id'], 'segment_id' => $segment['id']]) }}" method="POST">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <h2>MANAGE SEGMENT <button type="submit" class="btn btn-danger btn-xs">Remove</button></h2>
            </form>
            <form action="{{ route('admin.events.segment.edit', ['id' => $segment['event_id'], 'segment_id' => $segment['id']]) }}" method="POST">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Name</label>
                    {!! Form::text('name', e($segment['name']), ['class' => 'form-control', 'id' => 'name']) !!}
                </div>
                @if ($segment['type'] != 0)
                <div class="form-group">
                    <label for="title">Title</label>
                    {!! Form::select('title_id', $titles, e($segment['title_id']), ['class' => 'form-control', 'id' => 'title']) !!}
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="winner">Winner</label>
                                {!! Form::select('winner', $wrestlers, e($winner), ['class' => 'form-control', 'id' => 'winner']) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="loser">Loser</label>
                                {!! Form::select('loser', $wrestlers, e($loser), ['class' => 'form-control', 'id' => 'loser']) !!}
                    </div>
                </div>
                @endif
                <div class="form-group">
                    <label for="results-container">Results</label>
                    <div id="results-container">
                        {!! Form::textarea('result', $segment['result'], ['id' => 'editor']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>

    CKEDITOR.replace('editor', {
        toolbar: 'Standard'
    });

</script>

@endsection