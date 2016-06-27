@extends('master')

@section('content')

<div class="container">
    @include('admin.control-panel.control_panel_menu')
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin.forum.edit', ['category' => $forum['id']]) }}" method="POST">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $forum['id'] }}">
                <h2>EDIT FORUM CATEGORY <button type="submit" class="btn btn-danger btn-xs">Delete</button></h2>
            </form>
            <form action="{{ route('admin.forum.edit', ['category' => $forum['id']]) }}" method="POST">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ $forum['name'] }}">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" id="description" rows="3">{{ $forum['description'] }}</textarea>
                </div>
                <div class="form-group">
                    <label for="access-container">Access</label>
                    <div id="access-container">
                        <label class="radio-inline">
                            {!! Form::radio('access', 'Everyone', is_selected('Everyone', $forum['access'])) !!} Everyone
                        </label>
                        <label class="radio-inline">
                            {!! Form::radio('access', 'Staff', is_selected('Staff', $forum['access'])) !!} Staff
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="posting-container">Posting</label>
                    <div id="posting-container">
                        <label class="radio-inline">
                            {!! Form::radio('posting', 'Everyone', is_selected('Everyone', $forum['posting'])) !!} Everyone
                        </label>
                        <label class="radio-inline">
                            {!! Form::radio('posting', 'Staff', is_selected('Staff', $forum['posting'])) !!} Staff
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection