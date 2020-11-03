<div class="m-portlet__head">
	<div class="m-portlet__head-wrapper">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<span class="m-portlet__head-icon">
					<i class="{{ $icon }}"></i>
				</span>
				<h3 class="m-portlet__head-text m--font-primary">
					{{ strtoupper($title) }}
					<?php

					if(isset($updated_at) && !empty($updated_at))
					{
						?>
						<small title="Last updated">
							<i class="fa fa-clock"></i> {{ formatLocalTimestamp($updated_at) }}
						</small>
						<?php
					}

					?>
				</h3>
				<span id="page-title" hidden>{{ $title }}</span>
			</div>
		</div>
		<div class="m-portlet__head-tools">
			<ul class="m-portlet__nav">
				<li class="m-portlet__nav-item">
					<a href="{{ url()->previous() }}" title="Back" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-arrow-left"></i></a>
				</li>
				<li class="m-portlet__nav-item">
					<a href="{{ url()->full() }}" title="Refresh" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-refresh"></i></a>
				</li>
				<li class="m-portlet__nav-item">
					<a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-angle-down"></i></a>
				</li>
				<li class="m-portlet__nav-item">
					<a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-expand"></i></a>
				</li>
			</ul>
			<div class="btn-group m--margin-left-10">
				<button type="submit" form="main-form" class="btn btn-success m-btn m-btn--icon">
					<span>
						<i class="fa fa-save"></i>
						<span>Save</span>
					</span>
				</button>
				<button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split m-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
				<div class="dropdown-menu dropdown-menu-right">
					<button type="submit" class="dropdown-item" form="main-form">
						<i class="fa fa-save"></i>
						<span class="m--font-success">Save</span>
					</button>
					<button type="reset" class="dropdown-item" form="main-form">
						<i class="fa fa-undo"></i>
						<span class="m--font-secondary">Reset</span>
					</button>
					<?php

					if(isset($actions))
					{
						?>
						<div class="dropdown-divider"></div>
						@include('layouts.action_buttons', compact('actions'))
						<?php
					}

					?>
				</div>
			</div>
		</div>
	</div>
</div>