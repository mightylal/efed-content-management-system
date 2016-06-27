@inject('unread', 'Efed\Forum\Unread')
@inject('forumTopic', 'Efed\Models\ForumTopic')

@extends('master')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li class="active">Forum</li>
            </ol>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Topics</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($forums) > 0)
                        @foreach ($forums as $forum)
                            @if ($forum['access'] == 'Everyone' || ($forum['access'] == 'Staff' && Auth::user()->admin))
                            <tr>
                                <td>
                                    <h4><a href="{{ url('forum/' . $forum['id']) }}">{{ $forum['name'] }}</a>
                                    @if ($unread->category($forum['id'], Auth::id()))
                                        <small><label class="label label-success">new</label></small>
                                    @endif
                                    </h4><br>
                                    {{ $forum['description'] }}
                                </td>    
                                <td>{{ $forumTopic->categoryCount($forum['id']) }}</td>
                            </tr>
                            @endif
                        @endforeach
                    @else
                    <tr><td>There are no categories.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection