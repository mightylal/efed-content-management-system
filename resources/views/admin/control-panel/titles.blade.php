@extends('master')

@section('content')

<div class="container">
    @include('admin.control-panel.control_panel_menu')
    <div class="row">
        <div class="col-md-12">
            <h2>CREATE TITLE</h2>
            <form action="{{ url('admin/titles') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="type-container">Type</label>
                    <div id="type-container">
                        <div class="radio-inline">
                            <input type="radio" name="type" value="Single"> Single
                        </div>
                        <div class="radio-inline">
                            <input type="radio" name="type" value="Tag Team"> Tag Team
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
            <h2>TITLES</h2>
            @if (!empty($titles))
                <form action="{{ route('admin.titles') }}" method="POST">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
            @endif
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Placement</th>
                        </tr>
                    </thead>
                    <tbody id="sortable">
                        @if (count($titles) > 0)
                            @foreach ($titles as $title)
                            <tr class="ui-state-default">
                                <input type="hidden" name="id[]" value="{{ $title['id'] }}">
                                <td><a href="{{ url('admin/titles/' . $title['id'] . '/edit') }}">{{ $title['name'] }}</a></td>
                                <td>{{ $title['placement'] }}</td>
                            </tr>
                            @endforeach
                        @else
                        <tr><td>There are no titles. Create one above.</td></tr>
                        @endif
                    </tbody>
                </table>
                @if (!empty($titles))
                <div class="form-group">
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