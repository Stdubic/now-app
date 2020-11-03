<div class="{{ $width }}" id="{{ $id }}-container">
	<div class="m-portlet m-portlet--bordered m-portlet--rounded">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<span class="m-portlet__head-icon">
						<i class="{{ $icon }}"></i>
					</span>
					<h3 class="m-portlet__head-text">{{ $title }}</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					<li class="m-portlet__nav-item">
						<a href="javascript:updateCharts('#{{ $id }}');" title="Refresh" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-refresh"></i></a>
					</li>
					<li class="m-portlet__nav-item">
						<a href="javascript:resizeChart('{{ $id }}-container');" title="Resize" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-arrows-h"></i></a>
					</li>
				</ul>
			</div>
		</div>
		<div class="m-portlet__body m-portlet-fit--sides">
			<div id="{{ $id }}" class="chart-area" data-api="{{ $api }}" data-title="{{ $title }}"></div>
		</div>
	</div>
</div>