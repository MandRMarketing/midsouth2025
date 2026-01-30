<?php
//in case we need an ID or additional class names:
$unique_identifiers = get_sub_field('unique_identifiers');
$module_id = $unique_identifiers['id'];
$module_class_names = $unique_identifiers['class_names'];

//establish the MODULE background settings
$module_background_settings = get_sub_field('module_background');
$module_background_type = $module_background_settings['background_type'];

//build inline style attribute for background
$inline_style = '';
$data_attributes = '';

if ($module_background_type === 'color') {
    $module_background_color = $module_background_settings['background_color'];
    $inline_style = 'style="background-color:' . $module_background_color . '"';
} else if ($module_background_type === 'image') {
    $module_background_image = $module_background_settings['background_image'];
    $module_background_image_url = $module_background_image['url'];
    $module_background_image_position = $module_background_settings['background_image_position'];

    $inline_style = 'style="background-image:url(' . $module_background_image_url . '); background-repeat:no-repeat; background-size:cover;';

    // Add background position
    if ($module_background_image_position === 'center') {
        $inline_style .= ' background-position:center;';
    } else if ($module_background_image_position === 'left') {
        $inline_style .= ' background-position:left;';
    } else if ($module_background_image_position === 'right') {
        $inline_style .= ' background-position:right;';
    } else if ($module_background_image_position === 'top') {
        $inline_style .= ' background-position:top;';
    } else if ($module_background_image_position === 'bottom') {
        $inline_style .= ' background-position:bottom;';
    }

    $inline_style .= '"';

    //use an overlay if it's set up:
    if ($module_background_settings['include_overlay']) {
        $module_background_image_overlay = $module_background_settings['overlay_color'];
        $inline_style = 'style="background-image:url(' . $module_background_image_url . '); background-repeat:no-repeat; background-size:cover; --overlay-color:' . $module_background_image_overlay . ';';

        // Add background position
        if ($module_background_image_position === 'center') {
            $inline_style .= ' background-position:center;';
        } else if ($module_background_image_position === 'left') {
            $inline_style .= ' background-position:left;';
        } else if ($module_background_image_position === 'right') {
            $inline_style .= ' background-position:right;';
        } else if ($module_background_image_position === 'top') {
            $inline_style .= ' background-position:top;';
        } else if ($module_background_image_position === 'bottom') {
            $inline_style .= ' background-position:bottom;';
        }

        $inline_style .= '"';
        $data_attributes = 'data-background-overlay="true"';
    }
}

//build out the opening tag HTML with inline styles:
if ($module_id && $module_class_names) {
    $opening_tag = '<span id="' . $module_id . '" class="background-start ' . $module_class_names . '" ' . $inline_style . ' ' . $data_attributes . '>';
} else if ($module_id && !$module_class_names) {
    $opening_tag = '<span id="' . $module_id . '" class="background-start" ' . $inline_style . ' ' . $data_attributes . '>';
} else if (!$module_id && $module_class_names) {
    $opening_tag = '<span class="background-start ' . $module_class_names . '" ' . $inline_style . ' ' . $data_attributes . '>';
} else {
    $opening_tag = '<span class="background-start" ' . $inline_style . ' ' . $data_attributes . '>';
}

//we're always generating HTML for background-start
echo $opening_tag;
?>
<?php
// Note: This module doesn't close the tag - background-stop will close it
// Background styles are applied directly inline on the .background-start span
?>
