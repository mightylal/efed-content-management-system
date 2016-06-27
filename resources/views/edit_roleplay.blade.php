@extends('master')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('roleplay.edit', ['id' => $roleplay['id']]) }}" method="POST">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="name" id="title" class="form-control" value="{{ $roleplay['name'] }}">
                </div>
                <div class="form-group">
                    <label for="editor">Body</label>
                    <textarea name="rp" id="editor">{{ $roleplay['rp'] }}</textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update</button>
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