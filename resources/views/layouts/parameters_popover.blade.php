<?php

$rules = collect($route->signatureParameters())->where('name', 'request')->first() ?? [];
if($rules)
{
	$rules = (string) $rules->getType();
	$rules = new $rules;
	$rules = method_exists($rules, 'rules') ? $rules->rules() : [];
}

?>
<ul>
<?php

foreach($rules as $key => $rule)
{
	$rule = is_array($rule) ? implode(' | ', $rule) : $rule;
	?><li><code>{{ $key }} => {{ $rule }}</code></li><?php
}

?>
</ul>