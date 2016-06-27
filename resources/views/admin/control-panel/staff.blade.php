@extends('master')

@section('content')

<div class="container">
    @include('admin.control-panel.control_panel_menu')
    <div class="row">
        <div class="col-md-12">
            <h2>ADD STAFF</h2>
            <form action="{{ route('admin.staff') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Wrestler Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
            <h2>STAFF</h2>
            @if (count($staffs) > 0)
                <form action="{{ route('admin.staff') }}" method="POST">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($staffs as $staff)
                            <tr>
                                <td>{{ $staff->name }}</td>
                                <td><input type="checkbox" name="id[{{ $staff->id }}]" value="{{ $staff->id }}"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="form-group">
                    <button type="submit" class="btn btn-danger">Remove</button>
                </div>
            </form>
            @else
                <p>There are no staff members. You can add a staff member by filling out the form above.</p>
            @endif
        </div>
    </div>
</div>

@endsection