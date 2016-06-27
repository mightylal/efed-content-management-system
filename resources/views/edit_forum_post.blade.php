@extends('master')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>EDIT POST</h2>
            <form action="{{ route('forum.edit', ['category' => $category_id, 'topic' => $post['topic_id'], 'post' => $post['id']]) }}" method="POST">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="post-container">Post</label>
                    <div class="post-container">
                        <textarea name="post" id="editor">{{ $post['post'] }}</textarea>
                    </div>
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