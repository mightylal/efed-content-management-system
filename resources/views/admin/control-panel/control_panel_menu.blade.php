<ul class="nav nav-tabs">
    <li role="presentation" {{ is_active(['/admin/settings']) }}><a href="{{ route('admin.settings') }}">Settings</a></li>
    <li role="presentation" {{ is_active(['/admin/titles']) }}><a href="{{ route('admin.titles') }}">Titles</a></li>
    <li role="presentation" {{ is_active(['/admin/design']) }}><a href="{{ route('admin.design') }}">Design</a></li>
    <li role="presentation" {{ is_active(['/admin/pages']) }}><a href="{{ route('admin.pages') }}">Pages</a></li>
    <li role="presentation" {{ is_active(['/admin/forum']) }}><a href="{{ route('admin.forum') }}">Forum</a></li>
    @if (Auth::user()->admin)
        <li role="presentation" {{ is_active(['/admin/staff']) }}><a href="{{ route('admin.staff') }}">Staff</a></li>
    @endif
</ul>