@extends('master')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>CREATE ROLEPLAY</h2>
            <form action="{{ url('roleplays/create') }}" method="POST">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label for="event">Event</label>
                    <select name="event_id" id="event" class="form-control">
                        <option value="0">SELECT</option>
                        @if ($events)
                            @foreach ($events as $event)
                                <option value="{{ $event['id'] }}">{{ $event['name'] }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="name" id="title" class="form-control" placeholder="Title">
                </div>
                <div class="form-group">
                    <label for="editor">Body</label>
                    <textarea name="rp" id="editor" placeholder="Body"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
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