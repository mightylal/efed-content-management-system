@inject('carbon', 'Carbon\Carbon')
@inject('quote', 'Efed\Forum\Quote')

@extends('master')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="clearfix">
                <div class="pull-left">
                <ol class="breadcrumb">
                    <li><a href="{{ route('forum') }}">Forum</a></li>
                    <li><a href="{{ route('forum.category', ['category' => $forum['id']]) }}">{{ $forum['name'] }}</a></li>
                    <li class="active">{{ $forum['topics'][0]['name'] }}</li>
                </ol>
                </div>
                <div class="pull-right">
                    @if (Auth::check() && (Auth::user()->admin || Staff::is(Auth::id())))
                        <a href="{{ route('forum.lock', ['category' => $forum['id'], 'topic' => $forum['topics'][0]['id']]) }}">
                            @if ($forum['topics'][0]['locked'])
                                Unlock
                            @else
                                Lock
                            @endif
                        </a>
                        |
                        <a href="{{ route('forum.pin', ['category' => $forum['id'], 'topic' => $forum['topics'][0]['id']]) }}">
                            @if ($forum['topics'][0]['pinned'])
                                Unpin
                            @else
                                Pin
                            @endif
                        </a>
                    @endif
                </div>
            </div>
            @foreach ($posts as $post)
            <div class="row">
                <div class="col-md-2">
                    <img src="{{ wrestlerImage(isset($post->wrestler->image) ? $post->wrestler->image->url : null) }}" class="img-responsive" height="100" width="100" alt="user">
                </div>
                <div class="col-md-10">
                    <div class="clearfix"><em>{{ $post->wrestler->name }} - {{ $carbon->parse($post->created_at)->diffForHumans() }}</em>
                    @if (Auth::check() && ($forum['posting'] == 'Everyone' || (Auth::user()->admin || Staff::is(Auth::id()))) && !$forum['topics'][0]['locked'])
                        @if ($post['wrestler_id'] === Auth::id())
                            <div class="pull-right"><a href="{{ route('forum.edit', ['category' => $forum['id'], 'topic' => $forum['topics'][0]['id'], 'post' => $post->id]) }}">Edit</a> | <a class="quote-post" data-post="{{ $post->id }}" href="#">Quote</a></div>
                        @else
                            <div class="pull-right"><a class="quote-post" data-post="{{ $post->id }}" href="#">Quote</a></div>
                        @endif
                    @endif
                    </div><br>
                    <div id="{{ $post['id'] }}">
                        {!! $quote->handle($post['post']) !!}
                    </div>
                </div>
            </div>
            <hr>
            @endforeach
            <div class="text-right">

                {!! $posts->render() !!}
            </div>
            @if (Auth::check() && ($forum['posting'] == 'Everyone' || (Auth::user()->admin || Staff::is(Auth::id()))) && !$forum['topics'][0]['locked'])
                <h2>REPLY TO TOPIC</h2>
                <form action="{{ route('forum.topic', ['category' => $forum['id'], 'topic' => $forum['topics'][0]['id']]) }}" method="POST">
                    {{ csrf_field() }}
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

<script src="{{ asset('js/quote.js') }}"></script>
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>

    CKEDITOR.replace('editor', {
        toolbar: 'Standard'
    });

</script>

@endsection