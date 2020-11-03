@extends('layouts.master')

<?php

$form_action = route('instances.store');
$mode = 'VIEW';
$method = 'POST';
$actions = null;
$view_all = false;


if(isset($instance))
{

    $name = $instance->name;
    $description = $instance->description;
    $price = $instance->price / 100;
    $address = $instance->address;
    $city = $instance->city;
    $lat = $instance->latitude;
    $lng = $instance->longitude;
    $client_name = $instance['client_name'];
    $quantity_left = $instance['quantity_left'];
    $category = $instance->category['name'];
    $type = $instance->type['name'];
    $created_at = $instance->created_at;

}


$fields = [
    [
        'label' => 'Name',
        'tag' => 'input',
        'attributes' => [
            'id' => 'name',
            'name' => 'name',
            'type' => 'text',
            'value' => $name,
            'maxlength' => 50,
            'required' => true,
            'autofocus' => true,
            'readonly'=> 'readonly',
        ]
    ],
    [
        'label' => 'Type',
        'tag' => 'input',
        'attributes' => [
            'id' => 'type',
            'name' => 'type',
            'type' => 'text',
            'value' => $type,
            'maxlength' => 50,
            'required' => true,
            'autofocus' => true,
            'readonly'=> 'readonly',
        ]
    ],
    [
        'label' => 'Category',
        'tag' => 'input',
        'attributes' => [
            'id' => 'category',
            'name' => 'category',
            'type' => 'text',
            'value' => $category,
            'maxlength' => 50,
            'required' => true,
            'autofocus' => true,
            'readonly'=> 'readonly',
        ]
    ],
    [
        'label' => 'Client name',
        'tag' => 'input',
        'attributes' => [
            'id' => 'client_name',
            'name' => 'client_name',
            'type' => 'text',
            'value' => $client_name,
            'maxlength' => 50,
            'required' => true,
            'autofocus' => true,
            'readonly'=> 'readonly',
        ]
    ],
    [
        'label' => 'Description',
        'tag' => 'text',
        'attributes' => [
            'id' => 'description',
            'name' => 'description',
            'type' => 'text',
            'value' => $description,
            'maxlength' => 400,
            'required' => true,
            'autofocus' => true,
            'readonly'=> 'readonly',
        ]
    ],
    [
        'label' => 'Quantity left',
        'tag' => 'input',
        'attributes' => [
            'id' => 'quantity_left',
            'name' => 'quantity_left',
            'type' => 'input',
            'value' => $quantity_left,
            'maxlength' => 50,
            'required' => true,
            'autofocus' => true,
            'readonly'=> 'readonly',
        ]
    ],
    [
        'label' => 'Price',
        'tag' => 'input',
        'attributes' => [
            'id' => 'price',
            'name' => 'price',
            'type' => 'input',
            'value' => $price,
            'maxlength' => 50,
            'required' => true,
            'autofocus' => true,
            'readonly'=> 'readonly',
        ]
    ],
    [
        'label' => 'Address',
        'tag' => 'input',
        'attributes' => [
            'id' => 'address',
            'name' => 'address',
            'type' => 'input',
            'value' => $address,
            'maxlength' => 50,
            'required' => true,
            'autofocus' => true,
            'readonly'=> 'readonly',
        ]
    ],
    [
        'label' => 'City',
        'tag' => 'input',
        'attributes' => [
            'id' => 'city',
            'name' => 'city',
            'type' => 'input',
            'value' => $city,
            'maxlength' => 50,
            'required' => true,
            'autofocus' => true,
            'readonly'=> 'readonly',
        ]
    ],
    [
        'label' => 'Description',
        'tag' => 'input',
        'attributes' => [
            'id' => 'description',
            'name' => 'description',
            'type' => 'input',
            'value' => $description,
            'maxlength' => 50,
            'required' => true,
            'autofocus' => true,
            'readonly'=> 'readonly',
        ]
    ],


];
$fields_map = [

    [
        'label' => 'Location',
        'tag' => 'map',
        'base_name' => 'location',
        'lat' => $lat,
        'lng' => $lng,
        'attributes' => [
            'required' => true,
            'readonly'=> 'readonly',
        ]
    ],

];

?>

@section('content')
    @include('layouts.view', ['title' => $mode.' INSTANCE', 'icon' => 'fa fa-ban', 'created_at' => $created_at])
    <form class="m-form form-notify" action="{{ $form_action }}" method="post" autocomplete="off" id="main-form">
        <div class="m-portlet__body">
            <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
                <li class="nav-item m-tabs__item">
                    <a href="#btabs-basic" class="nav-link m-tabs__link active" data-toggle="tab"><i class="fa fa-info"></i> Basic </a>
                </li>
                <li class="nav-item m-tabs__item">
                    <a href="#btabs-onesignal" class="nav-link m-tabs__link" data-toggle="tab"><i class="fa fa fa-map-marker"></i> Map</a>
                </li>
            </ul>
            <form class="m-form form-notify" action="{{ $form_action }}" method="post" autocomplete="off" id="main-form">
                <div class="m-portlet__body tab-content">
                    @csrf
                    @method($method)
                    <div class="tab-pane active" id="btabs-basic" role="tabpanel">
                        <?php generate_form_fields($fields, $errors); ?>
                    </div>
                    <div class="tab-pane" id="btabs-onesignal" role="tabpanel">
                        <?php generate_form_fields($fields_map, $errors); ?>
                    </div>
                </div>
            </form>
        </div>
    </form>
@endsection