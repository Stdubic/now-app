@extends('layouts.master')

<?php

$last_month = Carbon\Carbon::now()->startOfMonth();



$date_scopes = [
    [
        'value' => 'Y',
        'label' => 'Year'
    ],
    [
        'value' => 'Y-m',
        'label' => 'Month'
    ],
    [
        'value' => 'Y-m-d',
        'label' => 'Day'
    ],
    [
        'value' => 'Y-m-d H',
        'label' => 'Hour'
    ]
];


$fields_daterange = [
    [
        'label' => 'Date range',
        'tag' => 'input',
        'attributes' => [
            'id' => 'chart-date-range',
            'type' => 'text',
            'value' => formatLocalTimestamp($last_month, setting('date_format')).' 00:00 - '.formatLocalTimestamp(null, setting('date_format')).' 23:59',
            'class' => 'chart-daterangepicker',
            'maxlength' => 50,
            'readonly' => true
        ]
    ]
];

$fields_dateformat = [
    [
        'label' => 'Scope',
        'tag' => 'select',
        'options' => $date_scopes,
        'selected' => 'Y-m-d',
        'attributes' => [
            'id' => 'chart-date-format',
            'required' => true,
            'onchange' => 'updateCharts();'
        ]
    ]
];

$stats = [
    [
        'title' => $app_user_count,
        'subtitle' => 'App Users Count',
        'icon' => 'la la-users',
        'color' => 'info',
        'route' => 'app-users.list'
    ],
    [
        'title' => $app_client_count,
        'subtitle' => 'App Client Count',
        'icon' => 'la la-user',
        'color' => 'info',
        'route' => 'app-clients.list'
    ],
    [
        'title' => $app_instance_count,
        'subtitle' => 'Instance Count',
        'icon' => 'la la-map-pin',
        'color' => 'info',
        'route' => 'instances.list'
    ],
	[
        'title' => $app_claims_count,
        'subtitle' => 'Claims Count',
        'icon' => 'la la-barcode',
        'color' => 'info',
    ],

];


$charts = [
    [
        'id' => 'chart-customers',
        'title' => 'Registered App Users',
        'icon' => 'fa fa-users',
        'width' => 'col-sm-12',
        'api' => route('api.charts.customers')
    ],
	[
        'id' => 'chart-clients',
        'title' => 'Registered App Clients',
        'icon' => 'fa fa-users',
        'width' => 'col-sm-12',
        'api' => route('api.charts.clients')
    ],
	[
        'id' => 'chart-instances',
        'title' => 'Instances',
        'icon' => 'fa fa-users',
        'width' => 'col-sm-12',
        'api' => route('api.charts.instances')
    ],
	[
        'id' => 'chart-claims',
        'title' => 'Claims',
        'icon' => 'fa fa-users',
        'width' => 'col-sm-12',
        'api' => route('api.charts.claims')
    ]
];

?>

@section('content')
	@include('layouts.list_header', ['title' => 'Dashboard', 'icon' => 'fa fa-chart-line'])
	<div class="m-portlet__body">
		<ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
			<li class="nav-item m-tabs__item">
				<a href="#btabs-basic" class="nav-link m-tabs__link active" data-toggle="tab">
					<i class="fa fa-info"></i> Basic
				</a>
			</li>
			<li class="nav-item m-tabs__item" onclick="updateCharts();">
				<a href="#btabs-charts" class="nav-link m-tabs__link" data-toggle="tab">
					<i class="fa fa-chart-line"></i>Charts
				</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="btabs-basic" role="tabpanel">
				<div class="m-pricing-table-1 m-pricing-table-1--fixed">
					<div class="m-pricing-table-1__items row">
                        <?php

                        foreach($stats as $stat)
                        {
                        ?>
						@include('layouts.stat', $stat)
                        <?php
                        }

                        ?>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="btabs-charts" role="tabpanel">
				<form class="m-form">
					<div class="m-form__heading">
						<div class="row">
							<div class="col-sm-6">
                                <?php generate_form_fields($fields_daterange, $errors); ?>
								<input type="hidden" id="chart-date-range-first" value="{{ formatTimestamp($last_month, 'Y-m-d 00:00') }}">
								<input type="hidden" id="chart-date-range-second" value="{{ formatTimestamp(null, 'Y-m-d 23:59') }}">
							</div>
							<div class="col-sm-6">
                                <?php generate_form_fields($fields_dateformat, $errors); ?>
							</div>
						</div>
					</div>
				</form>

				<div class="row">
                    <?php

                    foreach($charts as $chart)
                    {
                    ?>
					@include('layouts.chart', $chart)
                    <?php
                    }

                    ?>
				</div>
			</div>
		</div>
	</div>
@endsection
