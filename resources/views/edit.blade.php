@extends('master')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('home.edit') }}" method="POST">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <div class="form-group">
                    <textarea name="home" id="editor">{{ $content }}</textarea>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Submit Changes</button>
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
        toolbar: 'Fed'
    });

</script>

@endsection