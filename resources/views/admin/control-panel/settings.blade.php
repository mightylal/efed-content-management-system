@extends('master')

@section('content')

<div class="container">
    @include('admin.control-panel.control_panel_menu')
    <div class="row">
        <div class="col-md-12">
            <h2>SETTINGS</h2>
            <form action="{{ route('admin.settings') }}" method="POST">
                {{ method_field('PUT') }}
                {!! csrf_field() !!}
                <div class="form-group">
                    <label for="roleplay-limit">Roleplay Limit</label>
                    {!! Form::select('roleplayLimit',
                        [
                            1 => 1,
                            2 => 2,
                            3 => 3,
                            4 => 4,
                            5 => 5,
                            6 => 6,
                            7 => 7,
                            8 => 8,
                            9 => 9,
                            10 => 10
                        ], $settings['roleplayLimit'], ['class' => 'form-control', 'id' => 'roleplay-limit']
                    ) !!}
                </div>
                <div class="form-group">
                    <label for="grade-rights-container">Grade Rights</label>
                    <div id="grade-rights-container">
                        <label class="radio-inline">
                            {!! Form::radio('gradeRights', 'Everyone', is_selected('Everyone', $settings['gradeRights'])) !!} Everyone
                        </label>
                        <label class="radio-inline">
                            {!! Form::radio('gradeRights', 'Staff', is_selected('Staff', $settings['gradeRights'])) !!} Staff
                        </label>
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