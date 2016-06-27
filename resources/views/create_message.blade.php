@extends('master')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Create Message</h2>
                <form action="{{ route('messages.create') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="to">To</label>
                        <input type="text" name="name" id="to" class="form-control" placeholder="To">
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject">
                    </div>
                    <div class="form-group">
                        <label for="message-container">Message</label>
                        <div id="message-container">
                            <textarea name="message" id="editor" placeholder="Message" class="form-control"></textarea>
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

    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>

        CKEDITOR.replace('editor', {
            toolbar: 'Standard'
        });

    </script>

@endsection