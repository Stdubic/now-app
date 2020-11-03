<?php

if(isset($actions))
{
	$action_types = [
		'remove' => [
			'label' => 'Remove',
			'method' => 'DELETE',
			'state_class' => 'danger',
			'icon_class' => 'fa fa-trash-alt'
		],
		'activate' => [
			'label' => 'Activate',
			'method' => 'PATCH',
			'state_class' => 'warning',
			'icon_class' => 'fa fa-toggle-on'
		],
		'deactivate' => [
			'label' => 'Deactivate',
			'method' => 'PATCH',
			'state_class' => 'warning',
			'icon_class' => 'fa fa-toggle-off'
		],
		'fire-notification' => [
			'label' => 'Send',
			'method' => 'POST',
			'state_class' => 'info',
			'icon_class' => 'fa fa-broadcast-tower'
		],
		'modal-leaderboard' => [
			'label' => 'Leaderboard',
			'method' => 'GET',
			'state_class' => 'primary',
			'icon_class' => 'fa fa-sort-numeric-up',
			'attributes' => [
				'data-toggle' => 'modal',
				'data-target' => '#leaderboard-modal'
			]
		]
	];

	foreach($actions as $action)
	{
		$type = trim($action['type']);

		if(!array_key_exists($type, $action_types)) continue;

		$form_action = trim($action['action']);
		$method = $action_types[$type]['method'];
		$is_modal = isset($action_types[$type]['attributes']);

		if(!$is_modal && !getUser()->canViewRoute($form_action, $method)) continue;

		$state_class = $action_types[$type]['state_class'];
		$icon_class = $action_types[$type]['icon_class'];
		$label = $action_types[$type]['label'];
		$form_id = mt_rand();

		if($is_modal)
		{
			$attributes = $action_types[$type]['attributes'];
			$attributes['onclick'] = $form_action;

			foreach($attributes as $key => &$value)
			{
				if(is_bool($value))
				{
					if($value) $value = $key;
					else continue;
				}
				else $value = $key."='".$value."'";
			}

			$attributes = implode(' ', $attributes);
		}
		else $attributes = 'form="form-'.$form_id.'" onclick="gatherFormInputs(this.form);"';

		?>
		<button type="button" <?= $attributes ?> class="dropdown-item">
			<i class="{{ $icon_class }}"></i>
			<span class="m--font-{{ $state_class }}">{{ $label }}</span>
			<?php

			if(!$is_modal)
			{
				?>
				<form action="{{ $form_action }}" method="post" id="form-{{ $form_id }}" hidden>
					@csrf
					{{ method_field($method) }}
				</form>
				<?php
			}

			?>
		</button>
		<?php
	}
}