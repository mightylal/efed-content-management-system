@extends('master')

@section('content')

<div class="container">
    @include('admin.control-panel.control_panel_menu')
    <div class="row">
        <div class="col-md-12">
            <h2>CREATE PAGE</h2>
            <form action="{{ url('admin/pages') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Name">
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
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
            <h2>PAGES</h2>
            @if (!empty($pages))
            <form action="{{ route('admin.pages') }}" method="POST">
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
                    @if (count($pages) > 0)
                        @foreach ($pages as $page)
                            <tr class="ui-state-default">
                                <input type="hidden" name="id[]" value="{{ $page['id'] }}">
                                <td>{{ $page['name'] }}</td>
                                <td>{{ ucfirst($page['access']) }}</td>
                                <td>{{ $page['placement'] }}</td>
                            </tr>
                        @endforeach
                    @else
                       <tr><td>There are no pages. Create one above.</td></tr>
                    @endif
                </tbody>
            </table>
            @if (!empty($pages))
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