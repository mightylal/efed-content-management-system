@extends('master')

@section('content')

<div class="container">
    @include('admin.roster.menu')
    <div class="row">
        <div class="col-md-12">
            <h2>APPLICATIONS</h2>
            @if (!empty($applications))
            <form action="{{ route('admin.roster.applications') }}" method="POST">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                @endif
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Wrestler</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($applications))
                            @foreach ($applications as $applicant)
                                <tr>
                                    <td>{{ $applicant['name'] }}</td>
                                    <td><input type="checkbox" name="id[{{ $applicant['id'] }}]" value="{{ $applicant['id'] }}"></td>
                                </tr>
                            @endforeach
                        @else
                        <tr>
                            <td>There are no applications.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                @if (!empty($applications))
                <div class="form-group text-right">
                    <div class="radio-inline">
                        <input type="radio" name="decide" value="accept"> Accept
                    </div>
                    <div class="radio-inline">
                        <input type="radio" name="decide" value="decline"> Decline
                    </div>
                </div>
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            @endif
        </div>
    </div>
</div>

@endsection