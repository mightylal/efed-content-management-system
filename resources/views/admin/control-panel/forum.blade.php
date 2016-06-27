@extends('master')

@section('content')

<div class="container">
    @include('admin.control-panel.control_panel_menu')
    <div class="row">
        <div class="col-md-12">
            <h2>CREATE FORUM CATEGORY</h2>
            <form action="{{ route('admin.forum') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" id="description" rows="3" placeholder="Description"></textarea>
                </div>
                <div class="form-group">
                    <label for="access-container">Access</label>
                    <div id="access-container">
                        <label class="radio-inline">
                            <input type="radio" name="access" value="Everyone"> Everyone
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="access" value="Staff"> Staff
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="posting-container">Posting</label>
                    <div id="posting-container">
                        <label class="radio-inline">
                            <input type="radio" name="posting" value="Everyone"> Everyone
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="posting" value="Staff"> Staff
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
            <h2>FORUM CATEGORIES</h2>
            @if (!empty($forums))
            <form action="{{ route('admin.forum') }}" method="POST">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
            @endif
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Access</th>
                        <th>Placement</th>
                    </tr>
                </thead>
                <tbody id="sortable">
                    @if (count($forums) > 0)
                        @foreach ($forums as $forum)
                            <tr class="ui-state-default">
                                <input type="hidden" name="id[]" value="{{ $forum['id'] }}">
                                <td><a href="{{ route('admin.forum.edit', ['category' => $forum['id']]) }}">{{ $forum['name'] }}</a></td>
                                <td>{{ ucfirst($forum['access']) }}</td>
                                <td>{{ $forum['placement'] }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td>There are no categories. Create one above.</td></tr>
                    @endif
                </tbody>
            </table>
            @if (!empty($forums))
            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
            </form>
            @endif
        </div>
    </div>
</div>

@endsection

@section('scripts')

    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/sortable.js') }}"></script>

@endsection