@extends('master')

@section('content')

<div class="container">
    @include('admin.control-panel.control_panel_menu')
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin.titles.edit', ['id' => $title['id']]) }}" method="POST">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $title['id'] }}">
                <h2>EDIT TITLE <button type="submit" class="btn btn-danger btn-xs">Delete</button></h2>
            </form>
            <form action="{{ route('admin.titles.edit', ['id' => $title['id']]) }}" method="POST" enctype="multipart/form-data">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $title['name'] }}">
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" id="image">
                </div>
                <div class="form-group">
                    <label for="assign-to">Assign</label>
                    <div id="assign-to">
                        <div class="radio-inline">
                            <input type="radio" name="doAssign" value="yes"> Yes 
                        </div>
                        <div class="radio-inline">
                            <input type="radio" name="doAssign" value="no" checked> No
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="assign-container">Assign To</label>
                    <div id="assign-container">
                        @if ($title['type'] == "Single")
                            <select name="assign[]" class="form-control">
                                <option value="0">Vacant</option>
                                @foreach ($wrestlers as $wrestler)
                                    <option value="{{ $wrestler['id'] }}">{{ $wrestler['name'] }}</option>
                                @endforeach
                            </select>
                        @else
                            <div class="row">
                                <div class="col-md-6">
                                    <select name="assign[]" class="form-control">
                                        <option value="0">Vacant</option>
                                        @foreach ($wrestlers as $wrestler)
                                            <option value="{{ $wrestler['id'] }}">{{ $wrestler['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select name="assign[]" class="form-control">
                                        <option value="0">Vacant</option>
                                        @foreach ($wrestlers as $wrestler)
                                            <option value="{{ $wrestler['id'] }}">{{ $wrestler['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                    @endif
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