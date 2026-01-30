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
    $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="curved-top-slider ' . $module_class_names . '">';
} else if ($module_id && !$module_class_names) {
    $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="curved-top-slider">';
} else if (!$module_id && $module_class_names) {
    $opening_tag = '<' . $tag_type . ' class="curved-top-slider ' . $module_class_names . '">';
} else {
    $opening_tag = '<' . $tag_type . ' class="curved-top-slider">';
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
    $background_settings_tag = '<span class="background" style="background-color:' . $background_color . '"><span class="validator-text" data-nosnippet>background settings</span></span>';
} else if ($background_type === 'image') {
    $background_image = $background_settings['background_image'];
    $background_image_url = $background_image['url'];
    $background_image_position = $background_settings['background_image_position'];
    if ($background_settings['include_overlay']) {
        $background_image_overlay = $background_settings['overlay_color'];
        $background_settings_tag = '<span class="background" style="background-image:url(' . $background_image_url . '); --overlay-color:' . $background_image_overlay . '" data-background-overlay="true" data-background-image-position="' . $background_image_position . '"><span class="validator-text" data-nosnippet>background settings</span></span>';
    } else {
        $background_settings_tag = '<span class="background" style="background-image:url(' . $background_image_url . ')" data-background-image-position="' . $background_image_position . '"><span class="validator-text" data-nosnippet>background settings</span></span>';
    }
} else {
    $background_settings_tag = '';
}

//grab the container width from settings
$container_width = get_sub_field('container_width');

//declare variables for content
$slides = get_sub_field('slides');

//we're only generating HTML if the module has slides to display
if ($slides) :
    echo $opening_tag;
    $slider_id = 'curved-top-slider-' . rand(0, 999);
    $slide_count = count($slides);
?>
    <div id="<?= esc_attr($slider_id); ?>" class="curved-top-slider-container container" data-curved-top-slider data-slide-count="<?= $slide_count ?>">
        <div class="curved-top-slider__panes">
            <?php foreach ($slides as $index => $slide) :
                $slide_title = $slide['title'];
                $slide_icon = isset($slide['link']) ? $slide['link'] : (isset($slide['icon']) ? $slide['icon'] : null);
                $slide_header = $slide['header'];
                $slide_subtext = $slide['subtext'];
                $is_first = ($index === 0);
            ?>
                <div class="curved-top-slider__pane" id="<?= $slider_id ?>-pane-<?= $index ?>" data-index="<?= $index ?>" role="tabpanel" aria-labelledby="<?= $slider_id ?>-tab-<?= $index ?>" aria-hidden="<?= $is_first ? 'false' : 'true' ?>" <?= $is_first ? '' : 'hidden' ?>>
                    <?php if ($slide_icon && !empty($slide_icon['url'])) : ?>
                        <figure class="curved-top-slider__icon">
                            <img src="<?= esc_url($slide_icon['url']) ?>" alt="<?= esc_attr($slide_icon['alt'] ?: $slide_title ?: 'Slide icon') ?>">
                        </figure>
                    <?php endif; ?>
                    <?php if ($slide_header) : ?>
                        <h2 class="curved-top-slider__header"><?= esc_html($slide_header) ?></h2>
                    <?php endif; ?>
                    <?php if ($slide_subtext) : ?>
                        <p class="curved-top-slider__subtext"><?= esc_html($slide_subtext) ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="curved-top-slider__progress" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="<?= $slide_count ?>" aria-label="Slide progress">
            <div class="curved-top-slider__progress-track">
                <div class="curved-top-slider__progress-fill" style="width: <?= $slide_count > 0 ? (100 / $slide_count) : 0 ?>%"></div>
            </div>
        </div>

        <div class="curved-top-slider__titles" role="tablist" aria-label="Slide navigation">
            <?php foreach ($slides as $index => $slide) :
                $slide_title = $slide['title'];
                $is_first = ($index === 0);
            ?>
                <button type="button" class="curved-top-slider__title<?= $is_first ? ' is-active' : '' ?>" data-index="<?= $index ?>" role="tab" aria-selected="<?= $is_first ? 'true' : 'false' ?>" aria-controls="<?= $slider_id ?>-pane-<?= $index ?>" id="<?= $slider_id ?>-tab-<?= $index ?>">
                    <?= $slide_title ?>
                </button>
            <?php endforeach; ?>
        </div>

        <span class="container-settings" data-container-width="<?= esc_attr($container_width) ?>">
            <span class="validator-text" data-nosnippet>container settings</span>
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