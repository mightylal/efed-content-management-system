@inject('unread', 'Efed\Forum\Unread')
@inject('carbon', 'Carbon\Carbon')

@extends('master')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li><a href="{{ route('forum') }}">Forum</a></li>
                <li class="active">category name</li>
            </ol>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Topic</th>
                        <th class="text-right">Posts</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($topics) > 0)
                        @foreach ($topics as $topic)
                            <tr>
                                <td>
                                    <div class="clearfix">
                                        <a href="{{ route('forum.topic', ['category' => $forum['id'], 'topic' => $topic->id]) }}">{{ $topic->name }}</a>
                                        @if (!$unread->topic($topic->id, Auth::id()))
                                            <label class="label label-success">new</label>    
                                        @endif
                                        @if ($topic->pinned || $topic->locked)
                                        <div class="pull-right">
                                            @if ($topic->pinned)
                                                <label class="label label-info">Pinned</label>
                                            @endif
                                            @if ($topic->locked)
                                                <label class="label label-warning">Locked</label>
                                            @endif
                                        </div>
                                        @endif
                                    </div><br>
                                    Posted {{ $carbon->parse($topic->created_at)->diffForHumans() }} by {{ $topic->wrestlerName }}
                                </td>    
                                <td class="text-right">
                                    {{ $topic->posts }}<br>
                                    Last Updated {{ $carbon->parse($topic->updated_at)->diffForHumans() }}
                                </td>    
                            </tr>
                        @endforeach
                    @else
                    <tr><td>There are no topics.</td></tr>
                    @endif
                </tbody>
            </table>
            <div class="text-right">
                {!! $topics->render() !!}
            </div>
            @if (Auth::check() && $forum['posting'] == 'Everyone' || ($forum['posting'] == 'Staff' && (Auth::user()->admin || Staff::is(Auth::id()))))
                <h2>CREATE TOPIC</h2>
                <form action="{{ route('forum.category', ['category' => $forum['id']]) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="post-container">Post</label>
                        <div id="post-container">
                            <textarea name="post" id="editor" placeholder="Post"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>

    CKEDITOR.replace('editor', {
        toolbar: 'Standard'
    });

</script>

@endsection