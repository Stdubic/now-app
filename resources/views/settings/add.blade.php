@extends('layouts.master')

<?php

if(!isset($settings) || !$settings) redirect(route('home'));

$timezones = timezone_identifiers_list();
sort($timezones);

foreach($timezones as &$value)
{
	$value = [
		'value' => $value,
		'label' => $value
	];
}

$smtp_protocols = [
	[
		'value' => 'tls',
		'label' => 'TLS'
	],
	[
		'value' => 'ssl',
		'label' => 'SSL'
	]
];

$storages = [
	[
		'value' => 'public',
		'label' => 'Local'
	],
	[
		'value' => 's3',
		'label' => 'AWS S3 bucket'
	]
];

$media_visibilities = [
	[
		'value' => 'public',
		'label' => 'Public'
	],
	[
		'value' => 'private',
		'label' => 'Private'
	]
];

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

$fields_basic = [
	[
		'label' => 'App name',
		'tag' => 'input',
		'attributes' => [
			'id' => 'app_name',
			'name' => 'app_name',
			'type' => 'text',
			'value' => $settings->app_name,
			'maxlength' => 50,
			'required' => true,
			'autofocus' => true
		]
	],
	[
		'label' => 'Force HTTPS',
		'tag' => 'checkbox',
		'attributes' => [
			'id' => 'https',
			'name' => 'https',
			'value' => 1,
			'type' => 'checkbox',
			'checked' => boolval($settings->https)
		]
	],
	[
		'label' => 'Min. password length',
		'tag' => 'input',
		'attributes' => [
			'id' => 'min_pass_len',
			'name' => 'min_pass_len',
			'type' => 'number',
			'value' => $settings->min_pass_len,
			'min' => 1,
			'required' => true
		]
	],
	[
		'label' => 'Money currency code',
		'tag' => 'input',
		'attributes' => [
			'id' => 'currency_code',
			'name' => 'currency_code',
			'type' => 'text',
			'value' => $settings->currency_code,
			'maxlength' => 3,
			'required' => true
		]
	],
	[
		'label' => 'Google API key',
		'tag' => 'input',
		'attributes' => [
			'id' => 'google_api_key',
			'name' => 'google_api_key',
			'type' => 'text',
			'value' => $settings->google_api_key,
			'maxlength' => 50
		]
	]
];

$fields_mail = [
	[
		'label' => 'App e-mail',
		'tag' => 'input',
		'attributes' => [
			'id' => 'app_email',
			'name' => 'app_email',
			'type' => 'email',
			'value' => $settings->app_email,
			'maxlength' => 50
		]
	],
	[
		'label' => 'SMTP username',
		'tag' => 'input',
		'attributes' => [
			'id' => 'smtp_username',
			'name' => 'smtp_username',
			'type' => 'text',
			'value' => $settings->smtp_username,
			'maxlength' => 128
		]
	],
	[
		'label' => 'SMTP password',
		'tag' => 'input',
		'attributes' => [
			'id' => 'smtp_password',
			'name' => 'smtp_password',
			'type' => 'text',
			'value' => $settings->smtp_password,
			'maxlength' => 128
		]
	],
	[
		'label' => 'SMTP host',
		'tag' => 'input',
		'attributes' => [
			'id' => 'smtp_host',
			'name' => 'smtp_host',
			'type' => 'text',
			'value' => $settings->smtp_host,
			'maxlength' => 256
		]
	],
	[
		'label' => 'SMTP port',
		'tag' => 'input',
		'attributes' => [
			'id' => 'smtp_port',
			'name' => 'smtp_port',
			'type' => 'number',
			'value' => $settings->smtp_port,
			'min' => 1
		]
	],
	[
		'label' => 'SMTP protocol',
		'tag' => 'select',
		'options' => $smtp_protocols,
		'selected' => $settings->smtp_protocol,
		'attributes' => [
			'id' => 'smtp_protocol',
			'name' => 'smtp_protocol',
			'required' => true
		]
	]
];

$fields_datetime = [
	[
		'label' => 'Timezone',
		'tag' => 'select',
		'options' => $timezones,
		'selected' => $settings->timezone,
		'attributes' => [
			'id' => 'timezone',
			'name' => 'timezone',
			'required' => true
		]
	],
	[
		'label' => 'Date format',
		'tag' => 'input',
		'attributes' => [
			'id' => 'date_format',
			'name' => 'date_format',
			'type' => 'text',
			'value' => $settings->date_format,
			'maxlength' => 15,
			'required' => true
		]
	],
	[
		'label' => 'Time format',
		'tag' => 'input',
		'attributes' => [
			'id' => 'time_format',
			'name' => 'time_format',
			'type' => 'text',
			'value' => $settings->time_format,
			'maxlength' => 15,
			'required' => true
		]
	]
];

$fields_registration = [
	[
		'label' => 'Active (Web only)',
		'tag' => 'checkbox',
		'attributes' => [
			'id' => 'registration_active',
			'name' => 'registration_active',
			'value' => 1,
			'type' => 'checkbox',
			'checked' => boolval($settings->registration_active)
		]
	],
	[
		'label' => 'Registration role - Web',
		'tag' => 'select',
		'options' => $all_roles,
		'selected' => $settings->registration_role_id,
		'attributes' => [
			'id' => 'registration_role_id',
			'name' => 'registration_role_id',
			'required' => true
		]
	],
	[
		'label' => 'Registration role - API',
		'tag' => 'select',
		'options' => $all_roles,
		'selected' => $settings->registration_api_role_id,
		'attributes' => [
			'id' => 'registration_api_role_id',
			'name' => 'registration_api_role_id',
			'required' => true
		]
	]
];

$fields_jwt = [
	[
		'label' => 'Secret key',
		'tag' => 'input',
		'attributes' => [
			'id' => 'jwt_secret_key',
			'name' => 'jwt_secret_key',
			'type' => 'text',
			'value' => $settings->jwt_secret_key,
			'maxlength' => 128,
			'required' => true
		]
	],
	[
		'label' => 'Expiration time',
		'tag' => 'input',
		'group' => [
			'right' => 'min'
		],
		'attributes' => [
			'id' => 'jwt_expiration_time',
			'name' => 'jwt_expiration_time',
			'type' => 'number',
			'value' => $settings->jwt_expiration_time,
			'min' => 1,
			'required' => true
		]
	]
];

$fields_media = [
	[
		'label' => 'Storage',
		'tag' => 'select',
		'options' => $storages,
		'selected' => $settings->media_storage,
		'attributes' => [
			'id' => 'media_storage',
			'name' => 'media_storage',
			'required' => true
		]
	],
	[
		'label' => 'Visibility',
		'tag' => 'select',
		'options' => $media_visibilities,
		'selected' => $settings->media_visibility,
		'attributes' => [
			'id' => 'media_visibility',
			'name' => 'media_visibility',
			'required' => true
		]
	],
	[
		'label' => 'Max. upload size (per file)',
		'tag' => 'input',
		'group' => [
			'right' => 'MB'
		],
		'attributes' => [
			'id' => 'max_upload_size',
			'name' => 'max_upload_size',
			'type' => 'number',
			'value' => $settings->max_upload_size / (1024 * 1024),
			'min' => 1,
			'required' => true
		]
	],
	[
		'label' => 'Thumbnail width - landscape',
		'tag' => 'input',
		'group' => [
			'right' => 'px'
		],
		'attributes' => [
			'id' => 'thumb_width_landscape',
			'name' => 'thumb_width_landscape',
			'type' => 'number',
			'value' => $settings->thumb_width_landscape,
			'min' => 300,
			'max' => 1600,
			'required' => true
		]
	],
	[
		'label' => 'Thumbnail width - portrait',
		'tag' => 'input',
		'group' => [
			'right' => 'px'
		],
		'attributes' => [
			'id' => 'thumb_width_portrait',
			'name' => 'thumb_width_portrait',
			'type' => 'number',
			'value' => $settings->thumb_width_portrait,
			'min' => 300,
			'max' => 1600,
			'required' => true
		]
	],
	[
		'label' => 'Image filter (each extension in new line)',
		'tag' => 'textarea',
		'value' => $settings->image_filter,
		'attributes' => [
			'id' => 'image_filter',
			'name' => 'image_filter',
			'maxlength' => 500,
			'rows' => 10
		]
	],
	[
		'label' => 'Video filter (each extension in new line)',
		'tag' => 'textarea',
		'value' => $settings->video_filter,
		'attributes' => [
			'id' => 'video_filter',
			'name' => 'video_filter',
			'maxlength' => 500,
			'rows' => 10
		]
	]
];

$fields_aws = [
	[
		'label' => 'Access key ID',
		'tag' => 'input',
		'attributes' => [
			'id' => 'aws_access_key_id',
			'name' => 'aws_access_key_id',
			'type' => 'text',
			'value' => $settings->aws_access_key_id,
			'maxlength' => 128
		]
	],
	[
		'label' => 'Secret access key',
		'tag' => 'input',
		'attributes' => [
			'id' => 'aws_secret_access_key',
			'name' => 'aws_secret_access_key',
			'type' => 'text',
			'value' => $settings->aws_secret_access_key,
			'maxlength' => 128
		]
	],
	[
		'label' => 'Default region',
		'tag' => 'input',
		'attributes' => [
			'id' => 'aws_default_region',
			'name' => 'aws_default_region',
			'type' => 'text',
			'value' => $settings->aws_default_region,
			'maxlength' => 50
		]
	],
	[
		'label' => 'Bucket name',
		'tag' => 'input',
		'attributes' => [
			'id' => 'aws_bucket_name',
			'name' => 'aws_bucket_name',
			'type' => 'text',
			'value' => $settings->aws_bucket_name,
			'maxlength' => 50
		]
	],
	[
		'label' => 'Bucket URL',
		'tag' => 'input',
		'attributes' => [
			'id' => 'aws_bucket_url',
			'name' => 'aws_bucket_url',
			'type' => 'url',
			'value' => $settings->aws_bucket_url,
			'maxlength' => 1000
		]
	]
];

$fields_onesignal = [
	[
		'label' => 'REST API key',
		'tag' => 'input',
		'attributes' => [
			'id' => 'onesignal_rest_api_key',
			'name' => 'onesignal_rest_api_key',
			'type' => 'text',
			'value' => $settings->onesignal_rest_api_key,
			'maxlength' => 128
		]
	],
	[
		'label' => 'User auth key',
		'tag' => 'input',
		'attributes' => [
			'id' => 'onesignal_user_auth_key',
			'name' => 'onesignal_user_auth_key',
			'type' => 'text',
			'value' => $settings->onesignal_user_auth_key,
			'maxlength' => 128
		]
	],
	[
		'label' => 'User application key',
		'tag' => 'input',
		'attributes' => [
			'id' => 'onesignal_application_id',
			'name' => 'onesignal_application_id',
			'type' => 'text',
			'value' => $settings->onesignal_application_id,
			'maxlength' => 128
		]
	]
];

$fields_stripe = [
    [
        'label' => 'Stripe API key',
        'tag' => 'input',
        'attributes' => [
            'id' => 'stripe_rest_api_key',
            'name' => 'stripe_rest_api_key',
            'type' => 'text',
            'value' => $settings->stripe_rest_api_key,
            'maxlength' => 128
        ]
    ],
    [
        'label' => 'Stripe client id ',
        'tag' => 'input',
        'attributes' => [
            'id' => 'stripe_client_id',
            'name' => 'stripe_client_id',
            'type' => 'text',
            'value' => $settings->stripe_client_id,
            'maxlength' => 128
        ]
    ],
    [
        'label' => 'Stripe publishable key ',
        'tag' => 'input',
        'attributes' => [
            'id' => 'stripe_publishable_key',
            'name' => 'stripe_publishable_key',
            'type' => 'text',
            'value' => $settings->stripe_publishable_key,
            'maxlength' => 128
        ]
    ],
    [
        'label' => 'Currency ',
        'tag' => 'input',
        'attributes' => [
            'id' => 'currency',
            'name' => 'currency',
            'type' => 'text',
            'value' => $settings->currency,
            'maxlength' => 3
        ],
    ],
];
$fields_application_fee = [
    [
        'label' => 'Application fee',
        'tag' => 'input',
        'attributes' => [
            'id' => 'application_fee',
            'name' => 'application_fee',
            'type' => 'text',
            'value' => intval($settings->application_fee),
            'maxlength' => 10
        ],
    ]

];


?>

@section('content')
	@include('layouts.close_button', ['title' => 'SETTINGS', 'icon' => 'fa fa-cogs', 'updated_at' => $settings->updated_at])
	<div class="m-portlet__body">
		<ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
			<li class="nav-item m-tabs__item">
				<a href="#btabs-basic" class="nav-link m-tabs__link active" data-toggle="tab"><i class="fa fa-info"></i> Basic</a>
			</li>
			<li class="nav-item m-tabs__item">
				<a href="#btabs-mail" class="nav-link m-tabs__link" data-toggle="tab"><i class="fa fa-inbox"></i> Mail</a>
			</li>
			<li class="nav-item m-tabs__item">
				<a href="#btabs-datetime" class="nav-link m-tabs__link" data-toggle="tab"><i class="fa fa-calendar-alt"></i> Date & time</a>
			</li>
			<li class="nav-item m-tabs__item">
				<a href="#btabs-registration" class="nav-link m-tabs__link" data-toggle="tab"><i class="fa fa-user-plus"></i> Registration</a>
			</li>
			<li class="nav-item m-tabs__item">
				<a href="#btabs-jwt" class="nav-link m-tabs__link" data-toggle="tab"><i class="fa fa-lock"></i> JWT</a>
			</li>
			<li class="nav-item m-tabs__item">
				<a href="#btabs-media" class="nav-link m-tabs__link" data-toggle="tab"><i class="fa fa-image"></i> Media</a>
			</li>
			<li class="nav-item m-tabs__item">
				<a href="#btabs-aws" class="nav-link m-tabs__link" data-toggle="tab"><i class="fa fa-database"></i> AWS</a>
			</li>
			<li class="nav-item m-tabs__item">
				<a href="#btabs-onesignal" class="nav-link m-tabs__link" data-toggle="tab"><i class="fa fa-broadcast-tower"></i> OneSignal</a>
			</li>
			<li class="nav-item m-tabs__item">
				<a href="#btabs-stripe" class="nav-link m-tabs__link" data-toggle="tab"><i class="fab fa-stripe-s "></i> Stripe</a>
			</li>
			<li class="nav-item m-tabs__item">
				<a href="#btabs-application_fee" class="nav-link m-tabs__link" data-toggle="tab"><i class="fa fa-money-bill-alt "></i> Application fee</a>
			</li>
		</ul>
		<form class="m-form form-notify" action="{{ route('settings.update', $settings->id) }}" method="post" autocomplete="off" id="main-form">
			<div class="m-portlet__body tab-content">
				@csrf
				{{ method_field('PUT') }}
				<div class="tab-pane active" id="btabs-basic" role="tabpanel">
					<?php generate_form_fields($fields_basic, $errors); ?>
				</div>
				<div class="tab-pane" id="btabs-mail" role="tabpanel">
					@include('layouts.alert', ['icon' => 'fa fa-info', 'state' => 'primary', 'text' => 'Mail used for app notifications such as password resets.'])
					<?php generate_form_fields($fields_mail, $errors); ?>
				</div>
				<div class="tab-pane" id="btabs-datetime" role="tabpanel">
					@include('layouts.alert', ['icon' => 'fa fa-info', 'state' => 'primary', 'text' => 'For help with date/time formats check <strong><a href="https://php.net/manual/en/function.date.php" target="_blank" rel="external" class="m-link">official documentation</a></strong>.'])
					<?php generate_form_fields($fields_datetime, $errors); ?>
				</div>
				<div class="tab-pane" id="btabs-registration" role="tabpanel">
					<?php generate_form_fields($fields_registration, $errors); ?>
				</div>
				<div class="tab-pane" id="btabs-jwt" role="tabpanel">
					<?php generate_form_fields($fields_jwt, $errors); ?>
				</div>
				<div class="tab-pane" id="btabs-media" role="tabpanel">
					<?php generate_form_fields($fields_media, $errors); ?>
				</div>
				<div class="tab-pane" id="btabs-aws" role="tabpanel">
					<?php generate_form_fields($fields_aws, $errors); ?>
				</div>
				<div class="tab-pane" id="btabs-onesignal" role="tabpanel">
					<?php generate_form_fields($fields_onesignal, $errors); ?>
				</div>
				<div class="tab-pane" id="btabs-stripe" role="tabpanel">
                    <?php generate_form_fields($fields_stripe, $errors); ?>
				</div>
				<div class="tab-pane" id="btabs-application_fee" role="tabpanel">
                    <?php generate_form_fields($fields_application_fee, $errors); ?>
				</div>

			</div>
			@include('layouts.submit_button')
		</form>
	</div>
@endsection