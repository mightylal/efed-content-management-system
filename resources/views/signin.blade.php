@extends('master')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>SIGN IN</h2>
                <form action="{{ url('sign-in') }}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="remember"> Remember me
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection