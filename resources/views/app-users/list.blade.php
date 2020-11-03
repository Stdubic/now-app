@extends('layouts.master')

<?php

$actions = [
	[
		'type' => 'remove',
		'action' => route('app-users.remove-multi')
	],
	[
		'type' => 'activate',
		'action' => route('app-users.activate')
	],
	[
		'type' => 'deactivate',
		'action' => route('app-users.deactivate')
	]
];

?>

@section('content')
	@include('layouts.list_header', ['title' => 'App Users', 'icon' => 'fa fa-users', 'path' => 'app-users.add', 'actions' => $actions])
	<div class="m-portlet__body">
		<div class="table-responsive">
			<table width="100%" class="table table-bordered table-striped table-hover js-datatable">
				<thead>
					<tr>
						<th>Name</th>
						<th>E-mail</th>
						<th>User since</th>
						<th>Active</th>
						<th>@include('layouts.options_column_header')</th>
					</tr>
				</thead>
				<tbody align="center">
					<?php

					foreach($users as $row)
					{
						?>
						<tr>
							<td>{{ $row->first_name }}</td>
							<td><a href="mailto:{{ $row->email }}" class="m-link">{{ $row->email }}</a></td>
							<td>{{ formatLocalTimestamp($row->created_at, setting('date_format')) }}</td>
							<td>@include('layouts.bool_badge', ['value' => $row->active])</td>
							<td>@include('layouts.option_buttons', ['path' => route('app-users.edit', $row->id), 'value' => $row->id])</td>
						</tr>
						<?php
					}

					?>
				</tbody>
			</table>
		</div>
	</div>
@endsection