@inject('carbon', 'Carbon\Carbon')

@extends('master')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="clearfix">
                    <h2 class="pull-left">Messages</h2>
                    <div class="pull-right">
                        <a href="{{ route('messages.create') }}">Create Message</a>
                    </div>
                </div>
                <form action="{{ route('messages') }}" method="POST">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Received</th>
                            <th>Delete<br> <input type="checkbox" name="checkall" value="all"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($messages) > 0)
                            @foreach ($messages as $message)
                                <tr>
                                    <td>
                                        <a href="{{ route('message', ['message' => $message->id]) }}">{{ $message->subject }}</a>
                                        @if (!$message->has_viewed)
                                            <span class="label label-success">new</span>
                                        @endif
                                    </td>
                                    <td>{{ $carbon->parse($message->updated_at)->diffForHumans() }}</td>
                                    <td><input type="checkbox" name="id[{{ $message->id }}]" value="{{ $message->id }}"></td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td>You have no messages.</td></tr>
                        @endif
                        </tbody>
                    </table>
                    <div class="form-group clearfix">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script src="{{ asset('js/selectAll.js') }}"></script>

@endsection