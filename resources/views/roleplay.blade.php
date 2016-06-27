@extends('master')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="page-header">
                <img src="{{ wrestlerImage($roleplay['wrestler']['image']['url']) }}" class="img-responsive center-block" height="150" width="150" alt="Wrestler">
            </div>
            <p><strong>Wrestler</strong></p>
            <p>{{ $roleplay['wrestler']['name'] }}</p>
            <p><strong>Event</strong></p>
            @if ($roleplay['event'])
            <p><a href="{{ url('event/' . $roleplay['event']['id']) }}">{{ $roleplay['event']['name'] }}</a></p>
            @else
            <p>deleted</p>
            @endif
            <p><strong>Created</strong></p>
            <p>{{ $roleplay['created_at'] }}</p>
            <p><strong>Grade</strong></p>
            <p>{{ $roleplay['fed_score'] }}</p>
            @if ($canGrade)
            <form action="{{ route('canGrade', ['id' => $roleplay['id']]) }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="grade">Your Grade</label>
                    <select class="form-control" name="fed_grade" id="grade">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="comments">Comments</label>
                    <textarea class="form-control" name="comment" id="comments" placeholder="Comments (Optional)" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            @endif
        </div>
        <div class="col-md-9">
            @if (count($comments) > 0)
                @foreach ($comments as $comment)
                    <div class="bg-primary">
                        <p><strong>By:</strong> {{ $comment['wrestler']['name'] }}</p>
                        @if (isset($comment['fed_grade']))
                            <strong>{{ $comment['fed_grade'] }}</strong> -
                        @endif
                        {{ $comment['comment'] }}
                    </div>
                @endforeach
            @endif
            <div class="page-header">
                <h2 class="clearfix">{{ $roleplay['name'] }}
                @if ($canEdit)
                    <div class="pull-right">
                        <small><a href="{{ route('roleplay.edit', ['id' => $roleplay['id']]) }}">EDIT</a></small>
                    </div>
                @endif
                </h2>
            </div>
            <p>{!! $roleplay['rp'] !!}</p>
        </div>
    </div>
</div>

@endsection