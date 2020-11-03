@extends('layouts.master')

<?php

if(!isset($settings) || !$settings) redirect(route('home'));



$fields_basic = [
    [
        'label' => 'Title',
        'tag' => 'input',
        'attributes' => [
            'id' => 'title',
            'name' => 'title',
            'type' => 'text',
            'value' => $settings->title,
            'maxlength' => 50,
            'required' => true,
            'autofocus' => true
        ]
    ],
    [
        'label' => 'Terms of service',
        'tag' => 'textarea',
        'value' => $settings->tos,
        'attributes' => [
            'id' => 'tos',
            'name' => 'tos',
            'maxlength' => 5000,
            'rows' => 50,
            'cols' => 100
        ]
    ],
    [
        'label' => 'Privacy policy',
        'tag' => 'textarea',
        'value' => $settings->privacy_policy,
        'attributes' => [
            'id' => 'privacy_policy',
            'name' => 'privacy_policy',
            'maxlength' => 5000,
            'rows' => 50,
            'cols' => 100
        ]
    ]
];


?>

@section('content')
	@include('layouts.close_button', ['title' => 'SET TERMS OF SERVICE', 'icon' => 'fa fa-cogs', 'updated_at' => $settings->updated_at])
	<div class="m-portlet__body">
		<ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
			<li class="nav-item m-tabs__item">
				<a href="#btabs-basic" class="nav-link m-tabs__link active" data-toggle="tab"><i class="fa fa-info"></i> Basic</a>
			</li>

		</ul>
		<form class="m-form form-notify" action="{{ route('tos.update', $settings->id) }}" method="post" autocomplete="off" id="main-form">
			<div class="m-portlet__body tab-content">
				@csrf
				{{ method_field('PUT') }}
				<div class="tab-pane active" id="btabs-basic" role="tabpanel">
					<?php generate_form_fields($fields_basic, $errors); ?>
				</div>
			</div>
			@include('layouts.submit_button')
		</form>
	</div>
@endsection