<div class="m-portlet__head">
	<div class="m-portlet__head-wrapper">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<span class="m-portlet__head-icon">
					<i class="{{ $icon }}"></i>
				</span>
				<h3 class="m-portlet__head-text m--font-primary">{{ strtoupper($title) }}</h3>
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
				<?php

				if(isset($actions))
				{
					?>
					<li class="m-portlet__nav-item dropdown">
						<a href="#" class="m-portlet__nav-link m-portlet__nav-link--icon dropdown-toggle" title="Actions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="la la-cogs"></i>
						</a>
						<div class="dropdown-menu dropdown-menu-right">
							@include('layouts.action_buttons', compact('actions'))
						</div>
					</li>
					<?php
				}

				?>
			</ul>
			<?php

			if(isset($path) && getUser()->canViewRoute($path))
			{
				?>
				<a href="{{ route($path) }}" class="btn btn-success m-btn m-btn--icon m--margin-left-10">
					<span>
						<i class="fa fa-plus"></i>
						<span>Add</span>
					</span>
				</a>
				<?php
			}

			?>
		</div>
	</div>
</div>