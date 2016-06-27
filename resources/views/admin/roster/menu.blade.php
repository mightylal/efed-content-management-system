<ul class="nav nav-tabs">
    <li role="presentation" {{ is_active(['/admin/roster']) }}><a href="{{ route('admin.roster') }}">Roster</a></li>
    <li role="presentation" {{ is_active(['/admin/roster/applications']) }}><a href="{{ route('admin.roster.applications') }}">Applications</a></li>
</ul>