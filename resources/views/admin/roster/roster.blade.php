@extends('master')

@section('content')

<div class="container">
    @include('admin.roster.menu')
    <div class="row">
        <div class="col-md-12">
            <h2>ROSTER</h2>
            @if (!empty($wrestlers))
            <form action="{{ route('admin.roster') }}" method="POST">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
            @endif
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Wrestler</th>
                            <th>Release</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($wrestlers) > 0)
                            @foreach ($wrestlers as $wrestler)
                                @if (!$wrestler['admin'])
                                    <tr>
                                        <td>{{ $wrestler['name'] }}</td>
                                        <td><input type="checkbox" name="id[{{ $wrestler['id'] }}]" value="{{ $wrestler['id'] }}"></td>
                                    </tr>
                                @endif
                            @endforeach
                        @else
                        <tr>
                            <td>There are no wrestlers in the fed.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            @if (!empty($wrestlers))
                <div class="form-group">
                    <button type="submit" class="btn btn-danger">Release</button>
                </div>
            </form>
            @endif
        </div>
    </div>
</div>

@endsection