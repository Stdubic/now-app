@extends('layouts.master')

<?php

$form_action = route('users.store');
$mode = 'ADD';
$method = 'POST';
$actions = $updated_at = null;
$name = $email = '';
$role_id = setting('registration_role_id');
$timezone = setting('timezone');
$password = substr(md5(mt_rand()), 0, setting('min_pass_len'));
$active = true;

if(isset($user))
{
	$name = $user->name;
	$email = strtolower($user->email);
	$active = boolval($user->active);
	$role_id = $user->role_id;
	$timezone = $user->timezone;
	$password = '';
	$updated_at = $user->updated_at;

	$form_action = route('users.update', $user->id);
	$mode = 'UPDATE';
	$method = 'PUT';
	$actions = [
		[
			'type' => 'remove',
			'action' => route('users.remove', $user->id)
		]
	];
}

$timezones = timezone_identifiers_list();
sort($timezones);

foreach($timezones as &$value)
{
	$value = [
		'value' => $value,
		'label' => $value
	];
}

$all_roles = [
	[
		'value' => '',
		'label' => '-'
	]
];

foreach($roles as $row)
{
	$all_roles[] = [
		'value' => $row->id,
		'label' => $row->name
	];
}

$fields = [
	[
		'label' => 'Full name',
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
		'label' => 'E-mail (must be unique)',
		'tag' => 'input',
		'attributes' => [
			'id' => 'email',
			'name' => 'email',
			'type' => 'email',
			'value' => $email,
			'maxlength' => 50,
			'required' => true
		]
	],
	[
		'label' => 'Role',
		'tag' => 'select',
		'options' => $all_roles,
		'selected' => $role_id,
		'attributes' => [
			'id' => 'role_id',
			'name' => 'role_id',
			'required' => true
		]
	],
	[
		'label' => 'Timezone',
		'tag' => 'select',
		'options' => $timezones,
		'selected' => $timezone,
		'attributes' => [
			'id' => 'timezone',
			'name' => 'timezone',
			'required' => true
		]
	],
	[
		'label' => 'Password (min. '.setting('min_pass_len').' characters)',
		'tag' => 'input',
		'attributes' => [
			'id' => 'password',
			'name' => 'password',
			'type' => 'text',
			'value' => $password,
			'minlength' => setting('min_pass_len'),
			'required' => true
		]
	],
	[
		'label' => 'Confirm password',
		'tag' => 'input',
		'attributes' => [
			'id' => 'password_confirmation',
			'name' => 'password_confirmation',
			'type' => 'text',
			'minlength' => setting('min_pass_len'),
			'required' => true
		]
	],
	[
		'label' => 'Active',
		'tag' => 'checkbox',
		'attributes' => [
			'id' => 'active',
			'name' => 'active',
			'value' => 1,
			'type' => 'checkbox',
			'checked' => $active
		]
	]
];

?>

@section('content')
	@include('layouts.close_button', ['title' => $mode.' USER', 'icon' => 'fa fa-user-edit', 'actions' => $actions, 'updated_at' => $updated_at])
	<form class="m-form form-notify" action="{{ $form_action }}" method="post" autocomplete="off" id="main-form">
		<div class="m-portlet__body">
			@csrf
			{{ method_field($method) }}
			<?php generate_form_fields($fields, $errors); ?>
		</div>
		@include('layouts.submit_button')
	</form>
@endsection