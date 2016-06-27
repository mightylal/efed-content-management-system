<ul class="nav nav-tabs">
        <li role="presentation" {{ is_active(['/admin/events']) }}><a href="{{ route('admin.events') }}">Events</a></li>
        <li role="presentation" {{ is_active(['/admin/events/segment/create']) }}><a href="{{ route('admin.events.segment.create') }}">Book Segment</a></li>
    </ul>