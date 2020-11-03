@extends('layouts.master')

<?php

$form_action = route('roles.store');
$mode = 'ADD';
$method = 'POST';
$actions = $updated_at = null;
$name = $list_mode = '';
$routes = [];
$view_all = false;

if(isset($role))
{
	$name = $role->name;
	$view_all = boolval($role->view_all);
	$list_mode = $role->mode;
	$routes = $role->routes;
	$updated_at = $role->updated_at;

	$form_action = route('roles.update', $role->id);
	$mode = 'UPDATE';
	$method = 'PUT';
	$actions = [
		[
			'type' => 'remove',
			'action' => route('roles.remove', $role->id)
		]
	];
}

$all_routes = Route::getRoutes();

$list_modes = [
	[
		'value' => App\Role::LIST_MODE_WHITE,
		'label' => 'Whitelist'
	],
	[
		'value' => App\Role::LIST_MODE_BLACK,
		'label' => 'Blacklist'
	]
];

$fields = [
	[
		'label' => 'Name',
		'tag' => 'input',
		'attributes' => [
			'id' => 'name',
			'name' => 'name',
			'type' => 'text',
			'value' => $name,
			'maxlength' => 50,
			'required' => true,
			'autofocus' => true
		]
	],
	[
		'label' => 'View all records',
		'tag' => 'checkbox',
		'attributes' => [
			'id' => 'view_all',
			'name' => 'view_all',
			'value' => 1,
			'type' => 'checkbox',
			'checked' => $view_all
		]
	],
	[
		'label' => 'Mode',
		'tag' => 'select',
		'options' => $list_modes,
		'selected' => $list_mode,
		'attributes' => [
			'id' => 'mode',
			'name' => 'mode',
			'required' => true
		]
	]
];

?>

@section('content')
	@include('layouts.close_button', ['title' => $mode.' ROLE', 'icon' => 'fa fa-ban', 'actions' => $actions, 'updated_at' => $updated_at])
	<form class="m-form form-notify" action="{{ $form_action }}" method="post" autocomplete="off" id="main-form">
		<div class="m-portlet__body">
			@csrf
			{{ method_field($method) }}
			<?php generate_form_fields($fields, $errors); ?>
			<div class="form-group m-form__group">
				<label class="m-checkbox m-checkbox--solid m-checkbox--primary" title="Toggle all">
					<input type="checkbox" onclick="toggleCheckboxes(this.checked, 'routes-checkbox');"><span></span> Routes
				</label>
				<div class="m-checkbox-list m--margin-left-30">
					<?php

					foreach($all_routes as $route)
					{
						if(!in_array('check_role_permissions', $route->gatherMiddleware())) continue;

						$name = $route->getName();
						$pretty_path = preg_replace('%(\{.+?\})%', '<code>$1</code>', $route->uri());
						$checked = '';

						foreach($routes as $role_route)
						{
							if($role_route->route == $name)
							{
								$checked = 'checked';
								break;
							}
						}

						?>
						<label class="m-checkbox m-checkbox--solid m-checkbox--primary" data-container="body" data-toggle="m-popover" data-html="true" data-placement="left" title="{{ $pretty_path }}" data-content='@include('layouts.method_badge', ['methods' => $route->methods()])'>
							<input type="checkbox" class="routes-checkbox" name="routes[]" value="{{ $name }}" {{ $checked }}><span></span> {{ $name }}
						</label>
						<?php
					}

					?>
				</div>
			</div>
		</div>
		@include('layouts.submit_button')
	</form>
@endsection