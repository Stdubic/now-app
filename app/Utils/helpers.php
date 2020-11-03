<?php

function setting($key = null)
{
    static $value = null;
    if(!$value) $value = \App\Setting::get()->first();

    return $key && $value && isset($value->{$key}) ? $value->{$key} : $value;
}

function getUser()
{
    static $user = null;
    if($user) return $user;

    $guards = ['web', 'api','app_user-api','app_client-api'];

    foreach($guards as $guard)
    {
        if(\Illuminate\Support\Facades\Auth::guard($guard)->check())
        {
            $user = \Illuminate\Support\Facades\Auth::guard($guard)->user();
            break;
        }
    }

    return $user;
}

function formatTimestamp($carbon = null, $format = 'Y-m-d H:i:s')
{
    if(!$carbon) $carbon = Carbon\Carbon::now();
    return formatLocalTimestamp($carbon, $format, 'UTC');
}

function formatLocalTimestamp($carbon = null, $format = null, $timezone = null)
{
    $user = getUser();

    if(!$carbon) $carbon = Carbon\Carbon::now();
    if(!$format) $format = setting('date_format').' '.setting('time_format');
    if(!$timezone) $timezone = $user && $user->timezone ? $user->timezone : setting('timezone');

    return $carbon->setTimezone($timezone)->format($format);
}

function toJson($data)
{
    return json_encode($data, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES);
}

function generate_form_fields($fields, $errors = [])
{
    foreach($fields as $field)
    {
        $tag = strtolower(trim($field['tag']));
        $label = trim($field['label']);
        $attributes = $field['attributes'] ?? [];
        $id = $attributes['id'] ?? '';


        $name = $attributes['name'] ?? '';
        $has_error = ($errors && $errors->first($name)) ? 'has-danger' : '';

        if(!isset($attributes['class'])) $attributes['class'] = 'form-control m-input';
        else if(!empty($attributes['class'])) $attributes['class'] .= ' form-control m-input';

        switch($tag)
        {
            case 'input':
                {
                    $value = isset($attributes['value']) ? trim($attributes['value']) : '';
                    $attributes['value'] = old($name) ? trim(old($name)) : $value;

                    ?>
                    <div class="form-group m-form__group <?= $has_error ?>">
                        <label for="<?= $id ?>"><?= $label ?></label>
                        <?php

                        if(isset($field['group']))
                        {
                            $field_group = $field['group'];

                            ?>
                            <div class="input-group m-input-group">
                                <?php

                                if(isset($field_group['left']))
                                {
                                    ?>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><?= $field_group['left'] ?></span>
                                    </div>
                                    <?php
                                }

                                ?>
                                <input <?= stringifyAttr($attributes); ?>>
                                <?php

                                if(isset($field_group['right']))
                                {
                                    ?>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><?= $field_group['right'] ?></span>
                                    </div>
                                    <?php
                                }

                                ?>
                            </div>
                            <?php
                        }
                        else
                        {
                            ?>
                            <input <?= stringifyAttr($attributes); ?>>
                            <?php
                        }

                        if($errors->first($name))
                        {
                            ?>
                            <div class="form-control-feedback">* <?= $errors->first($name) ?></div>
                            <?php
                        }

                        ?>
                    </div>
                    <?php

                    break;
                }
            case 'textarea':
                {
                    $value = isset($field['value']) ? trim($field['value']) : '';
                    $value = old($name) ? trim(old($name)) : $value;

                    ?>
                    <div class="form-group m-form__group <?= $has_error ?>">
                        <label for="<?= $id ?>"><?= $label ?></label>
                        <textarea <?= stringifyAttr($attributes); ?> onblur="this.value = this.value.trim();"><?= $value ?></textarea>
                        <?php

                        if($errors->first($name))
                        {
                            ?>
                            <div class="form-control-feedback">* <?= $errors->first($name) ?></div>
                            <?php
                        }

                        ?>
                    </div>
                    <?php

                    break;
                }
            case 'html':
                {
                    $value = isset($field['value']) ? trim($field['value']) : '';
                    $value = old($name) ? trim(old($name)) : $value;

                    ?>
                    <div class="form-group m-form__group <?= $has_error ?>">
                        <label><?= $label ?></label>
                        <div class="summernote" data-textarea="<?= $attributes['id'] ?>"><?= $value ?></div>
                        <textarea hidden <?= stringifyAttr($attributes); ?>><?= $value ?></textarea>
                        <?php

                        if($errors->first($name))
                        {
                            ?>
                            <div class="form-control-feedback">* <?= $errors->first($name) ?></div>
                            <?php
                        }

                        ?>
                    </div>
                    <?php

                    break;
                }
            case 'map':
                {
                    $base_name = $field['base_name'];
                    $lat = $field['lat'] ?? '';
                    $lng = $field['lng'] ?? '';

                    $fields_lat = [
                        [
                            'label' => 'Latitude',
                            'tag' => 'input',
                            'attributes' => array_merge([
                                'id' => $base_name.'_lat',
                                'name' => $base_name.'_lat',
                                'type' => 'number',
                                'value' => $lat,
                                'min' => -90,
                                'max' => 90,
                                'step' => 'any',
                                'onchange' => 'coordinateChange(\''.$base_name.'\');'
                            ], $attributes)
                        ]
                    ];

                    $fields_lng = [
                        [
                            'label' => 'Longitude',
                            'tag' => 'input',
                            'attributes' => array_merge([
                                'id' => $base_name.'_lng',
                                'name' => $base_name.'_lng',
                                'type' => 'number',
                                'value' => $lng,
                                'min' => -180,
                                'max' => 180,
                                'step' => 'any',
                                'onchange' => 'coordinateChange(\''.$base_name.'\');',
                                'required' => true
                            ], $attributes)
                        ]
                    ];

                    ?>
                    <div class="form-group m-form__group <?= $has_error ?>">
                        <?php

                        if($label)
                        {
                            ?>
                            <label><?= $label ?></label>
                            <?php
                        }

                        ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <?php generate_form_fields($fields_lat, $errors); ?>
                            </div>
                            <div class="col-sm-6">
                                <?php generate_form_fields($fields_lng, $errors); ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group m-form__group">
                        <div class="map-area" data-basename="<?= $base_name ?>"></div>
                    </div>
                    <?php

                    break;
                }

            case 'checkbox':
            case 'radio':
                {
                    ?>
                    <div class="form-group m-form__group <?= $has_error ?>">
                        <label><?= $label ?></label>
                        <div class="m-<?= $tag ?>-list">
                            <input <?= stringifyAttr($attributes); ?> data-switch="true" data-size="small" data-on-text="Yes" data-off-text="No" data-radio-all-off="true">
                        </div>
                        <?php

                        if($errors->first($name))
                        {
                            ?>
                            <div class="form-control-feedback">* <?= $errors->first($name) ?></div>
                            <?php
                        }

                        ?>
                    </div>
                    <?php

                    break;
                }
            case 'select':
                {
                    $options = $selected = [];

                    if(strpos($attributes['class'], 'no-bootstrap-select') === false) $attributes['class'] .= ' m-bootstrap-select';
                    if(isset($field['options'])) $options = $field['options'];
                    if(isset($field['selected'])) $selected = (array) $field['selected'];

                    ?>
                    <div class="form-group m-form__group <?= $has_error ?>">
                        <label for="<?= $id ?>"><?= $label ?></label>
                        <select <?= stringifyAttr($attributes); ?> data-live-search="true" data-live-search-normalize="true" data-live-search-placeholder="Search...">
                            <?php generate_select_field($options, $selected); ?>
                        </select>
                        <?php

                        if($errors->first($name))
                        {
                            ?>
                            <div class="form-control-feedback">* <?= $errors->first($name) ?></div>
                            <?php
                        }

                        ?>
                    </div>
                    <?php

                    break;
                }
        }
    }
}

function stringifyAttr($attributes)
{
    foreach($attributes as $key => &$value)
    {
        if(is_bool($value))
        {
            if($value) $value = $key;
            else continue;
        }
        else $value = $key.'="'.$value.'"';
    }

    return implode(' ', $attributes);
}

function generate_select_field($options, $selected)
{
    foreach($options as $key => $option)
    {
        if(is_string($key))
        {
            ?>
            <optgroup label="<?= $key ?>">
                <?php generate_select_field($option, $selected); ?>
            </optgroup>
            <?php
        }
        else
        {
            $value = $option['value'];
            $opt_label = trim($option['label']);
            $checked = in_array($value, $selected) ? 'selected' : '';

            ?>
            <option value="<?= $value ?>" <?= $checked ?>><?= $opt_label ?></option>
            <?php
        }
    }
}

function generate_gallery_fields($data)
{
    $fields = $data['fields'];
    $gallery_id = $data['gallery_id'];
    $upload_dir = isset($data['upload_dir']) ? $data['upload_dir'] : null;
    $actions = isset($data['actions']) ? $data['actions'] : [];
    $width = isset($data['width']) ? $data['width'] : 'col-sm-6';
    $errors = isset($data['errors']) ? $data['errors'] : [];

    generate_form_fields($fields, $errors);

    ?>
    <div class="row gallery-container" id="<?= $gallery_id ?>"></div>
    <?php

    $storage = new \App\Http\Controllers\MediaStorage;
    $files = $storage->files($upload_dir);

    if(empty($files)) return;

    $marked_removal_key = $storage::MARKED_REMOVAL_KEY;
    $visibility_key = $storage::VISIBILITY_KEY;
    $old_names_key = $storage::OLD_NAMES_KEY;
    $new_names_key = $storage::NEW_NAMES_KEY;

    $media_visibilities = [
        [
            'value' => 'public',
            'label' => 'Public'
        ],
        [
            'value' => 'private',
            'label' => 'Private'
        ]
    ];

    ?>
    <div class="row">
        <?php

        foreach($files as $key => $file)
        {
            $name = pathinfo($file, PATHINFO_FILENAME);
            $ext = $storage->getExt($file);
            $size = round($storage->size($file) / (1024 * 1024), 2);
            $url = $storage->url($file);
            $visibility = $storage->getVisibility($file);
            $lastModified = formatLocalTimestamp($storage->lastModified($file));

            $fields = [
                [
                    'label' => 'Name',
                    'tag' => 'input',
                    'group' => [
                        'right' => '.'.$ext
                    ],
                    'attributes' => [
                        'id' => 'media-'.$gallery_id.'-new-name-'.$key,
                        'name' => 'media['.$new_names_key.'][]',
                        'type' => 'text',
                        'maxlength' => 250,
                        'value' => $name,
                        'required' => true
                    ]
                ],
                [
                    'label' => 'Visibility',
                    'tag' => 'select',
                    'options' => $media_visibilities,
                    'selected' => $visibility,
                    'attributes' => [
                        'id' => 'media-'.$gallery_id.'-visibility-'.$key,
                        'name' => 'media['.$visibility_key.'][]',
                        'required' => true
                    ]
                ]
            ];

            ?>
            <div class="<?= $width ?>">
                <div class="row">
                    <div class="col-sm-6">
                        <figure>
                            <?php

                            if($storage->isImage($file))
                            {
                                ?>
                                <a target="_blank" href="<?= $url ?>">
                                    <img class="img-thumbnail lazy-load" data-src="<?= $storage->url($storage->getThumb($file)) ?>">
                                </a>
                                <?php
                            }
                            else if($storage->isVideo($file))
                            {
                                ?>
                                <video controls class="img-thumbnail" preload="none">
                                    <source src="<?= $url ?>" type="video/<?= $ext ?>">
                                </video>
                                <?php
                            }

                            ?>
                            <figcaption>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <a href="<?= $url ?>" class="m-link" title="Download" download>
                                            <i class="fa fa-download"></i> (<?= $size ?> MB)
                                        </a>
                                    </div>
                                    <div class="col-sm-6" align="right"><?= $lastModified ?></div>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                    <div class="col-sm-6">
                        <?php generate_form_fields($fields, $errors); ?>
                        <input type="hidden" name="media[<?= $old_names_key ?>][]" value="<?= $file ?>">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group m-form__group">
                                    <div class="m-checkbox-inline">
                                        <label class="m-checkbox m-checkbox--solid m-checkbox--danger">
                                            <input type="checkbox" name="media[<?= $marked_removal_key ?>][]" value="<?= $file ?>"><span></span>
                                            Remove
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-form__group">
                                    <div class="m-radio-list">
                                        <?php

                                        foreach($actions as $action)
                                        {
                                            $type = $action['type'];
                                            $values = isset($action['checked']) ? ((array) $action['checked']) : [];
                                            $checked = in_array($file, $values) ? 'checked' : '';

                                            ?>
                                            <label class="m-<?= $type ?> m-<?= $type ?>--solid m-<?= $type ?>--<?= $action['state'] ?>">
                                                <input type="<?= $type ?>" name="<?= $action['name'] ?>" value="<?= $file ?>" <?= $checked ?>><span></span>
                                                <?= $action['label'] ?>
                                            </label>
                                            <?php
                                        }

                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }

        ?>
    </div>
    <?php
}