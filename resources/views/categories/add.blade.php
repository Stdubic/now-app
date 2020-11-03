@extends('layouts.master')

<?php

$form_action = route('categories.store');
$mode = 'ADD';
$method = 'POST';
$actions  = $image_upload_dir  = null;
$name = $list_type = $routes = '';
$view_all = false;


if(isset($category))
{
    $name = $category->name;

    $form_action = route('categories.update', $category->id);
    $mode = 'UPDATE';
    $method = 'PUT';
    $image_upload_dir = 'category/'.$category->id.'/image';


    $actions = [
        [
            'type' => 'remove',
            'action' => route('categories.remove', $category->id)
        ]
    ];
}


$fields = [
    [
        'label' => 'Title',
        'tag' => 'input',
        'attributes' => [
            'id' => 'name',
            'name' => 'name',
            'type' => 'text',
            'value' => $name,
            'maxlength' => 50,
            'required' => true,
            'autofocus' => true
        ]
    ]

];


$fields_image = [
    [
        'label' => 'Image',
        'tag' => 'input',
        'attributes' => [
            'id' => 'image',
            'name' => 'media[image]',
            'type' => 'file',
            'accept' => 'image/*',
            'onchange' => 'showMedia(this, \'image-gallery\');'
        ]
    ]

];



?>

@section('content')
    @include('layouts.close_button', ['title' => $mode.' CATEGORY', 'icon' => 'fa fa-ban', 'actions' => $actions])

        <div class="m-portlet__body">
            <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
                <li class="nav-item m-tabs__item">
                    <a href="#btabs-basic" class="nav-link m-tabs__link active" data-toggle="tab"><i class="fa fa-info"></i> Basic</a>
                </li>
                <li class="nav-item m-tabs__item">
                    <a href="#btabs-media" class="nav-link m-tabs__link" data-toggle="tab"><i class="fa fa-image"></i> Icon</a>
                </li>
            </ul>
            <form class="m-form form-notify" action="{{ $form_action }}" method="post" autocomplete="off" id="main-form" enctype="multipart/form-data">
                <div class="m-portlet__body tab-content">
                    @csrf
                    {{ method_field($method) }}
                    <div class="tab-pane active" id="btabs-basic" role="tabpanel">
                        <?php generate_form_fields($fields, $errors); ?>

                    </div>
                    <div class="tab-pane" id="btabs-media" role="tabpanel">
                        <?php


                        generate_gallery_fields([
                            'fields' => $fields_image,
                            'gallery_id' => 'image-gallery',
                            'upload_dir' => $image_upload_dir,
                            'errors' => $errors
                        ]);


                        ?>
                    </div>

                </div>
                @include('layouts.submit_button')
            </form>
        </div>
@endsection