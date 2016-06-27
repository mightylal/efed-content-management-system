@extends('master')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>REGISTER</h2>
                <form action="{{ url('/register') }}" method="post">
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
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password">
                    </div>
                    <div class="form-group">
                        <label for="name">Wrestler Name</label>
                        <input type="text" class="form-control" name="name" id="name">
                    </div>
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="text" class="form-control" name="age" id="age">
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender" class="form-control" size="1">
                            <option value="0">SELECT</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Unknown">Unknown</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="height">Height</label>
                        <input type="text" class="form-control" name="height" id="height">
                    </div>
                    <div class="form-group">
                        <label for="weight">Weight</label>
                        <input type="text" class="form-control" name="weight" id="weight">
                    </div>
                    <div class="form-group">
                        <label for="human">Who put the 1 in 21-1?</label>
                        <input type="text" name="human" id="human" class="form-control" placeholder="(hint: Brock Lesnar)">
                    </div>
                    <div class="form-group">
                        <span class="help-block">By registering with EFedZone you agree to the <a href="{{ url('terms') }}">Terms of Service</a>.</span>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection