<div class="m-alert m-alert--icon m-alert--icon-solid m-alert--outline alert alert-{{ $state }} alert-dismissible fade show" role="alert">
	<div class="m-alert__icon">
		<i class="{{ $icon }}"></i>
		<span></span>
	</div>
	<div class="m-alert__text"><?= $text ?></div>
	<div class="m-alert__close">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="Close"></button>
	</div>
</div>