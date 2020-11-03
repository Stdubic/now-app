@extends('layouts.master')

<?php

$form_action = route('feedback.store');
$mode = 'ADD';
$method = 'POST';
$actions = null;
$title = $list_type = $routes = '';
$view_all = false;
$message = '';


if(isset($feedback))
{
    $message= $feedback->message;



    $form_action = route('feedback.update', $feedback->id);
    $mode = 'UPDATE';
    $method = 'PUT';
    $actions = [
        [
            'type' => 'remove',
            'action' => route('feedback.remove', $feedback->id)
        ]
    ];
}

$fields = [
    [
        'label' => 'Feedback message',
        'tag' => 'textarea',
        'value' => $message,
        'attributes' => [
            'id' => 'message',
            'name' => 'message',
            'maxlength' => 5000,
            'rows' => 50,
            'cols' => 100
        ]

    ]

];

?>

@section('content')
    @include('layouts.close_button', ['title' => $mode.' FEEDBACK MESSAGE', 'icon' => 'fa fa-ban', 'actions' => $actions])
    <form class="m-form form-notify" action="{{ $form_action }}" method="post" autocomplete="off" id="main-form">
        <div class="m-portlet__body">
            @csrf
            {{ method_field($method) }}
            <?php generate_form_fields($fields, $errors); ?>
        </div>
        @include('layouts.submit_button')
    </form>
@endsection
