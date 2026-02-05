<?php
//we may not always want to use <section>, and instead opt for <aside> or <div>
$tag_type = get_sub_field('tag_type');

//in case we need an ID or additional class names:
$unique_identifiers = get_sub_field('unique_identifiers');
$module_id = $unique_identifiers['id'];
$module_class_names = $unique_identifiers['class_names'];

//build out the closing tag HTML
$closing_tag = '</' . $tag_type . '>';

//build out the opening tag HTML:
if ($module_id && $module_class_names) {
    $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="cards ' . $module_class_names . '">';
} else if ($module_id && !$module_class_names) {
    $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="cards">';
} else if (!$module_id && $module_class_names) {
    $opening_tag = '<' . $tag_type . ' class="cards ' . $module_class_names . '">';
} else {
    $opening_tag = '<' . $tag_type . ' class="cards">';
}

//grab the top & bottom padding settings values, for both desktop & mobile
$padding_settings = get_sub_field('padding');
$top_padding_desktop = $padding_settings['top_padding_desktop'];
$bottom_padding_desktop = $padding_settings['bottom_padding_desktop'];
$top_padding_mobile = $padding_settings['top_padding_mobile'];
$bottom_padding_mobile = $padding_settings['bottom_padding_mobile'];

//build out the padding settings <span> HTML:
$padding_settings_tag = '<span class="padding" data-top-padding-desktop="' . $top_padding_desktop . '" data-bottom-padding-desktop="' . $bottom_padding_desktop . '" data-top-padding-mobile="' . $top_padding_mobile . '" data-bottom-padding-mobile="' . $bottom_padding_mobile . '"><span class="validator-text" data-nosnippet>padding settings</span></span>';

//establish the background settings
$background_settings = get_sub_field('background');
$background_type = $background_settings['background_type'];

if ($background_type === 'color') {
    $background_color = $background_settings['background_color'];

    //build out the background settings <span> HTML:
    $background_settings_tag = '<span class="background" style="background-color:' . $background_color . '"><span class="validator-text" data-nosnippet>background settings</span></span>';
} else if ($background_type === 'image') {
    $background_image = $background_settings['background_image'];
    $background_image_url = $background_image['url'];
    $background_image_position = $background_settings['background_image_position'];

    //use an overlay if it's set up:
    if ($background_settings['include_overlay']) {
        $background_image_overlay = $background_settings['overlay_color'];

        //build out the background settings <span> HTML:
        $background_settings_tag = '<span class="background" style="background-image:url(' . $background_image_url . '); --overlay-color:' . $background_image_overlay . '" data-background-overlay="true" data-background-image-position="' . $background_image_position . '"><span class="validator-text" data-nosnippet>background settings</span></span>';
    } else {
        //build out the background settings <span> HTML:
        $background_settings_tag = '<span class="background" style="background-image:url(' . $background_image_url . ')" data-background-image-position="' . $background_image_position . '"><span class="validator-text" data-nosnippet>background settings</span></span>';
    }
} else {
    //transparent background, so no need for settings <span> HTML:
    $background_settings_tag = '';
}

//text color settings
$text_color_settings = get_sub_field('text_color');

//if any of these color fields are used, we'll use them to build out CSS variables
if ($text_color_settings['headings_color'] || $text_color_settings['body_text_color'] || $text_color_settings['link_color'] || $text_color_settings['link_hover_color']) {
    $text_color_attribute = 'style="';

    if ($text_color_settings['headings_color']) {
        $text_color_attribute .= '--headings-color:' . $text_color_settings['headings_color'] . ';';
    }

    if ($text_color_settings['body_text_color']) {
        $text_color_attribute .= '--body-text-color:' . $text_color_settings['body_text_color'] . ';';
    }

    if ($text_color_settings['link_color']) {
        $text_color_attribute .= '--link-color:' . $text_color_settings['link_color'] . ';';
    }

    if ($text_color_settings['link_hover_color']) {
        $text_color_attribute .= '--link-hover-color:' . $text_color_settings['link_hover_color'] . ';';
    }

    $text_color_attribute .= '"';
}

if (
    empty($text_color_settings['headings_color']) &&
    empty($text_color_settings['body_text_color']) &&
    empty($text_color_settings['link_color']) &&
    empty($text_color_settings['link_hover_color'])
) {
    $text_color_attribute = '';
}

//grab the container width and column count from settings
$container_width = get_sub_field('container_width');
$column_count = get_sub_field('column_count');

//declare variables for content
$intro_content = get_sub_field('intro_content');
$cards = get_sub_field('cards');

//we're only generating HTML if the module has cards to display
if ($cards) :
    echo $opening_tag;
?>
    <?php if ($intro_content) : ?>
        <div class="intro-content-row">
            <div class="container">
                <div class="content" <?= $text_color_attribute ?>>
                    <?= $intro_content ?>
                </div>
                <span class="container-settings" data-container-width="<?= $container_width ?>">
                    <span class="validator-text" data-nosnippet>settings</span>
                </span>
            </div>
        </div>
    <?php endif; ?>
    <div class="cards-container container">
        <div class="cards-grid" data-grid="grid" data-row-gap="small" data-column-gap="small" data-column-count="<?= $column_count ?>">
            <?php
            foreach ($cards as $card) :
                $card_content = $card['content'];
            ?>
                <div class="card" <?= $text_color_attribute ?>>
                    <div class="card-content">
                        <?= $card_content ?>
                    </div>
                </div>
            <?php
            endforeach;
            ?>
        </div>
        <span class="container-settings" data-container-width="<?= $container_width ?>">
            <span class="validator-text" data-nosnippet>settings</span>
        </span>
    </div>
    <span class="module-settings" data-nosnippet>
        <?= $padding_settings_tag ?>
        <?= $background_settings_tag ?>
        <span class="validator-text">module settings</span>
    </span>
<?php
    echo $closing_tag;
endif;
?>