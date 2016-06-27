@extends('master')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('page', ['page' => $page['id']]) }}" method="POST">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <input type="hidden" name="id[]" value="{{ $page['id'] }}">
                <h2>EDIT PAGE <button type="submit" class="btn btn-danger btn-xs">Delete</button></h2>
            </form>
            <form action="{{ route('page.edit', ['page' => $page['id']]) }}" method="POST">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <div class="form-group">
                    <label id="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $page['name'] }}">
                </div>
                <div class="form-group">
                    <label for="access-container">Access</label>
                    <div id="access-container">
                        <div class="radio-inline">
                            {!! Form::radio('access', 'Everyone', is_selected('Everyone', e($page['access']))) !!} Everyone
                        </div>
                        <div class="radio-inline">
                            {!! Form::radio('access', 'Staff', is_selected('Staff', e($page['access']))) !!} Staff
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label id="editor-container">Content</label>
                    <div id="editor-container">
                        <textarea name="content" id="editor">{{ $page['content'] }}</textarea>
                    </div>
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