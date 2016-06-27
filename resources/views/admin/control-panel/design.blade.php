@extends('master')

@section('content')

<div class="container">
    @include('admin.control-panel.control_panel_menu')
    <div class="row">
        <div class="col-md-12">
            <h2>DESIGN</h2>
            <form action="{{ url('admin/design') }}" method="POST" enctype="multipart/form-data">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="primary-color1">Primary Color (1)</label>
                    <input type="text" class="form-control" name="primary1" id="primary-color1" value="{{ $style['primary1'] }}">
                    <p class="help-block">Controls: body background color</p>
                </div>
                <div class="form-group">
                    <label for="primary-color2">Primary Color (2)</label>
                    <input type="text" class="form-control" name="primary2" id="primary-color2" value="{{ $style['primary2'] }}">
                    <p class="help-block">Controls: bottom gradient color for header, drop down menu background color</p>
                </div>
                <div class="form-group">
                    <label for="secondary-color1">Secondary Color (1)</label>
                    <input type="text" class="form-control" name="secondary1" id="secondary-color1" value="{{ $style['secondary1'] }}">
                    <p class="help-block">Controls: top menu link color, admin tab color, link color, text color</p>
                </div>
                <div class="form-group">
                    <label for="secondary-color2">Secondary Color (2)</label>
                    <input type="text" class="form-control" name="secondary2" id="secondary-color2" value="{{ $style['secondary2'] }}">
                    <p class="help-block">Controls: top gradient color for header, admin tab border color, roster champion background, forum quote background</p>
                </div>
                <div class="form-group">
                    <label for="secondary-color3">Secondary Color (3)</label>
                    <input type="text" class="form-control" name="secondary3" id="secondary-color3" value="{{ $style['secondary3'] }}">
                    <p class="help-block">Controls: dropdown menu hover color, table striped row background color, admin tab hover color</p>
                </div>
                <div class="form-group">
                    <label for="secondary-color4">Secondary Color (4)</label>
                    <input type="text" class="form-control" name="secondary4" id="secondary-color4" value="{{ $style['secondary4'] }}">
                    <p class="help-block">Controls: table border color, divider color, applications badge background color</p>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection