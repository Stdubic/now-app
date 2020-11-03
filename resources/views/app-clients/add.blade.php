@extends('layouts.master')

<?php

$form_action = route('app-clients.store');
$mode = 'ADD';
$method = 'POST';
$actions = $updated_at = null;
$name = $email = $address = $post_code = $contact_number = $city = $lat = $lng = $category_id ='';
$role_id = setting('registration_api_role_id');
$timezone = setting('timezone');
$password = substr(md5(mt_rand()), 0, setting('min_pass_len'));
$active = true;

if(isset($user))
{
	$name = $user->name;
	$email = strtolower($user->email);
    $address = $user->address;
    $post_code = $user->post_code;
    $contact_number = $user->contact_number;
    $category_id = $user->category;
    $city = $user->city;
    $lat = $user->latitude;
    $lng = $user->longitude;
    $active = boolval($user->active);
	$timezone = $user->timezone;
	$password = '';
	$updated_at = $user->updated_at;

	$form_action = route('app-clients.update', $user->id);
	$mode = 'UPDATE';
	$method = 'PUT';
	$actions = [
		[
			'type' => 'remove',
			'action' => route('app-clients.remove', $user->id)
		]
	];
}

foreach($categories as $row)
{
    $all_categories[] = [
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
        'label' => 'Category',
        'tag' => 'select',
        'options' => $all_categories,
        'selected' => $category_id,
        'attributes' => [
            'id' => 'category',
            'name' => 'category',
            'required' => true
        ]
    ],
    [
        'label' => 'Address',
        'tag' => 'input',
        'attributes' => [
            'id' => 'address',
            'name' => 'address',
            'type' => 'text',
            'value' => $address,
            'maxlength' => 50,
            'required' => true,
            'autofocus' => true
        ]
    ],
	[
        'label' => 'Post code',
        'tag' => 'input',
        'attributes' => [
            'id' => 'post_code',
            'name' => 'post_code',
            'type' => 'text',
            'value' => $post_code,
            'maxlength' => 50,
            'required' => true,
            'autofocus' => true
        ]
    ],
	[
        'label' => 'Contact number',
        'tag' => 'input',
        'attributes' => [
            'id' => 'contact_number',
            'name' => 'contact_number',
            'type' => 'text',
            'value' => $contact_number,
            'maxlength' => 50,
            'required' => true,
            'autofocus' => true
        ]
    ],
	[
        'label' => 'City',
        'tag' => 'input',
        'attributes' => [
            'id' => 'city',
            'name' => 'city',
            'type' => 'text',
            'value' => $city,
            'maxlength' => 50,
            'required' => true,
            'autofocus' => true
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

$fields_map = [

    [
        'label' => 'Location',
        'tag' => 'map',
        'base_name' => 'location',
        'lat' => $lat,
        'lng' => $lng,
        'attributes' => [
            'required' => true
        ]
    ],

];

?>

@section('content')
	@include('layouts.close_button', ['title' => $mode.' APP CLIENT', 'icon' => 'fa fa-user-edit', 'actions' => $actions, 'updated_at' => $updated_at])
	<div class="m-portlet__body">
		<ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
			<li class="nav-item m-tabs__item">
				<a href="#btabs-basic" class="nav-link m-tabs__link active" data-toggle="tab"><i class="fa fa-info"></i> Basic </a>
			</li>
			<li class="nav-item m-tabs__item">
				<a href="#btabs-map" class="nav-link m-tabs__link" data-toggle="tab"><i class="fa fa fa-map-marker"></i> Map</a>
			</li>
            <?php if(isset($instances))
            {
            ?>
			<li class="nav-item m-tabs__item">
				<a href="#btabs-instances" class="nav-link m-tabs__link" data-toggle="tab"><i class="fa fa fa-map-marker"></i> Instances</a>
			</li>
            <?php
            }
            ?>
		</ul>
		<form class="m-form form-notify" action="{{ $form_action }}" method="post" autocomplete="off" id="main-form">
			<div class="m-portlet__body tab-content">
				@csrf
				@method($method)
				<div class="tab-pane active" id="btabs-basic" role="tabpanel">
                    <?php generate_form_fields($fields, $errors); ?>
				</div>
				<div class="tab-pane" id="btabs-map" role="tabpanel">
                    <?php generate_form_fields($fields_map, $errors); ?>
				</div>

                <?php if(isset($instances))
				{
                ?>


				<div class="tab-pane" id="btabs-instances" role="tabpanel">
					@include('layouts.list_header_just_title', ['title' => 'INSTANCES', 'icon' => 'fa fa-ban'])
					<div class="m-portlet__body">
						<div class="table-responsive">
							<table width="100%" class="table table-bordered table-striped table-hover js-datatable">
								<thead>
								<tr>
									<th>Name</th>
									<th>Quantity left</th>
									<th>Type</th>
									<th>Category</th>
									<th>Time start</th>
									<th>Time end</th>
									<th>Price in {{setting('currency')}}</th>
									<th>Created at</th>
									<th>@include('layouts.options_column_header')</th>
								</tr>
								</thead>
								<tbody align="center">
                                <?php

                                foreach($instances as $row)
                                {
                                ?>
								<tr>
									<td>{{ $row->name }}</td>
									<td>{{ $row['quantity_left'] }}</td>
									<td>{{ $row->type['name'] }}</td>
									<td>{{ $row->category['name'] }}</td>
									<td>{{ $row->time_start }}</td>
									<td>{{ $row->time_end }}</td>
									<td>{{ $row->price / 100}}</td>
									<td>{{ $row->created_at->format(setting('date_format')) }}</td>
									<td>@include('layouts.option_buttons', ['path' => route('instances.edit', $row->id), 'value' => $row->id])</td>
								</tr>
                                <?php
                                }

                                ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<?php
				}
				?>

			</div>
			@include('layouts.submit_button')
		</form>
	</div>



@endsection