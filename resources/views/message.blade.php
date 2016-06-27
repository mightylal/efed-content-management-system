@inject('carbon', 'Carbon\Carbon')

@extends('master')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>MAIL</h2>
                @if (count($messages) > 0)
                    @foreach ($messages as $message)
                        <div class="row">
                            <div class="col-md-12">
                                <p>{!! $message->message !!}</p>
                                <p><small>Posted by <a href="{{ route('roster.wrestler', ['wrestler' => $message->wrestlerSlug]) }}">{{ $message->wrestlerName }}</a> {{ $carbon->parse($message->created_at)->diffForHumans() }}</small></p>
                                <hr>
                            </div>
                        </div>
                    @endforeach
                @endif
                <h2>REPLY</h2>
                <form action="{{ route('message', ['message' => $id]) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="message-container">Message</label>
                        <div id="message-container">
                            <textarea name="message" id="editor" placeholder="Message" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Send</button>
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