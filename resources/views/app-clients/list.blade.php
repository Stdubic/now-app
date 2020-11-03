@extends('layouts.master')

<?php

$actions = [
	[
		'type' => 'remove',
		'action' => route('app-clients.remove-multi')
	],
	[
		'type' => 'activate',
		'action' => route('app-clients.activate')
	],
	[
		'type' => 'deactivate',
		'action' => route('app-clients.deactivate')
	]
];

?>

@section('content')
	@include('layouts.list_header', ['title' => 'App Clients', 'icon' => 'fa fa-users', 'path' => 'app-clients.add', 'actions' => $actions])
	<div class="m-portlet__body">
		<div class="table-responsive">
			<table width="100%" class="table table-bordered table-striped table-hover js-datatable">
				<thead>
					<tr>
						<th>Name</th>
						<th>E-mail</th>
						<th>Address</th>
						<th>Contact number</th>
						<th>City</th>
						<th>Post code</th>
						<th>Stripe Connect</th>
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
							<td>{{ $row->name }}</td>
							<td><a href="mailto:{{ $row->email }}" class="m-link">{{ $row->email }}</a></td>
							<td>{{ $row->address }}</td>
							<td>{{ $row->contact_number }}</td>
							<td>{{ $row->city }}</td>
							<td>{{ $row->post_code }}</td>
							<td>@include('layouts.bool_badge', ['value' => boolval($row->stripe_account)])</td>
							<td>{{ formatLocalTimestamp($row->created_at, setting('date_format')) }}</td>
							<td>@include('layouts.bool_badge', ['value' => $row->active])</td>
							<td>@include('layouts.option_buttons', ['path' => route('app-clients.edit', $row->id), 'value' => $row->id])</td>
						</tr>
						<?php
					}

					?>
				</tbody>
			</table>
		</div>
	</div>
@endsection