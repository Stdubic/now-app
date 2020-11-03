@extends('layouts.master')

<?php

$actions = [
    [
        'type' => 'remove',
        'action' => route('instances.remove-multi')
    ]
];

?>

@section('content')
    @include('layouts.list_header', ['title' => 'INSTANCES', 'icon' => 'fa fa-ban'])
    <div class="m-portlet__body">
        <div class="table-responsive">
            <table width="100%" class="table table-bordered table-striped table-hover js-datatable">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Client name</th>
                    <th>Quantity left</th>
                    <th>Type</th>
                    <th>Category</th>
                    <th>Time start</th>
                    <th>Time end</th>
                    <th>Price in {{setting('currency')}}</th>
                    <th>Created at</th>
                    <th>@include('layouts.options_column_header')</th>
                </tr>
                </thead>
                <tbody align="center">
                <?php

                foreach($instances as $row)
                {
                ?>
                <tr>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row['client_name'] }}</td>
                    <td>{{ $row['quantity_left'] }}</td>
                    <td>{{ $row->type['name'] }}</td>
                    <td>{{ $row->category['name'] }}</td>
                    <td>{{ $row->time_start }}</td>
                    <td>{{ $row->time_end }}</td>
                    <td>{{ $row->price / 100}}</td>
                    <td>{{ $row->created_at->format(setting('date_format')) }}</td>
                    <td>@include('layouts.option_buttons', ['path' => route('instances.edit', $row->id), 'value' => $row->id])</td>
                </tr>
                <?php
                }

                ?>
                </tbody>
            </table>
        </div>
    </div>
@endsection