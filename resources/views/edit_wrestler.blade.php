@extends('master')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>EDIT WRESTLER</h2>
                <form action="{{ route('roster.wrestler.edit', ['wrestler' => $wrestler['slug']]) }}" method="POST" enctype="multipart/form-data">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ $wrestler['name'] }}">
                    </div>
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="text" name="age" id="age" class="form-control" placeholder="Age" value="{{ $wrestler['age'] }}">
                    </div>
                    <div class="form-group">
                        <label for="gender-container">Gender</label>
                        <div id="gender-container">
                            <div class="radio-inline">
                                {!! Form::radio('gender', 'Male', is_selected($wrestler['gender'], 'Male')) !!} Male
                            </div>
                            <div class="radio-inline">
                                {!! Form::radio('gender', 'Female', is_selected($wrestler['gender'], 'Female')) !!} Female
                            </div>
                            <div class="radio-inline">
                                {!! Form::radio('gender', 'Unknown', is_selected($wrestler['gender'], 'Unknown')) !!} Unknown
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="height">Height</label>
                        <input type="text" name="height" id="height" class="form-control" placeholder="Height" value="{{ $wrestler['height'] }}">
                    </div>
                    <div class="form-group">
                        <label for="weight">Weight</label>
                        <input type="text" name="weight" id="weight" class="form-control" placeholder="Weight" value="{{ $wrestler['weight'] }}">
                    </div>
                    <div class="form-group">
                        <label for="bio-container">Bio</label>
                        <div id="bio-container">
                            <textarea name="bio" id="editor" placeholder="Bio">{{ $wrestler['bio'] }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Edit</button>
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