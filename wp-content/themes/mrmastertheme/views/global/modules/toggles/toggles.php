<?php
$section_id = get_sub_field('section_id');
$section_classes = get_sub_field('section_classes');
$toggles = get_sub_field('toggles'); // repeater
$module_title = get_sub_field('module_title');
$container_width = get_sub_field('container_width');
$tag_type = get_sub_field('tag_type') ?: 'section';
$add_toggle_sections = get_sub_field('add_toggle_sections');
$intro_content = get_sub_field('intro_content');
$toggles_sections = get_sub_field('toggles_sections');
$toggles = get_sub_field('toggles');

// Build opening/closing tag
$closing_tag = '</' . $tag_type . '>';
if ($section_id && $section_classes) {
    $opening_tag = '<' . $tag_type . ' id="' . esc_attr($section_id) . '" class="toggles ' . esc_attr($section_classes) . '">';
} elseif ($section_id) {
    $opening_tag = '<' . $tag_type . ' id="' . esc_attr($section_id) . '" class="toggles">';
} elseif ($section_classes) {
    $opening_tag = '<' . $tag_type . ' class="toggles ' . esc_attr($section_classes) . '">';
} else {
    $opening_tag = '<' . $tag_type . ' class="toggles">';
}

// Text color (optional)
$text_color_settings = get_sub_field('text_color');
$text_color_attribute = '';
if (!empty($text_color_settings['headings_color']) || !empty($text_color_settings['body_text_color']) || !empty($text_color_settings['link_color']) || !empty($text_color_settings['link_hover_color'])) {
    $text_color_attribute = ' style="';
    if (!empty($text_color_settings['headings_color'])) {
        $text_color_attribute .= '--headings-color:' . $text_color_settings['headings_color'] . ';';
    }
    if (!empty($text_color_settings['body_text_color'])) {
        $text_color_attribute .= '--body-text-color:' . $text_color_settings['body_text_color'] . ';';
    }
    if (!empty($text_color_settings['link_color'])) {
        $text_color_attribute .= '--link-color:' . $text_color_settings['link_color'] . ';';
    }
    if (!empty($text_color_settings['link_hover_color'])) {
        $text_color_attribute .= '--link-hover-color:' . $text_color_settings['link_hover_color'] . ';';
    }
    $text_color_attribute .= '"';
}

// Padding
$padding_settings = get_sub_field('padding');
$top_padding_desktop = $padding_settings['top_padding_desktop'] ?? '';
$bottom_padding_desktop = $padding_settings['bottom_padding_desktop'] ?? '';
$top_padding_mobile = $padding_settings['top_padding_mobile'] ?? '';
$bottom_padding_mobile = $padding_settings['bottom_padding_mobile'] ?? '';
$padding_settings_tag = '<span class="padding" data-top-padding-desktop="' . esc_attr($top_padding_desktop) . '" data-bottom-padding-desktop="' . esc_attr($bottom_padding_desktop) . '" data-top-padding-mobile="' . esc_attr($top_padding_mobile) . '" data-bottom-padding-mobile="' . esc_attr($bottom_padding_mobile) . '"><span data-nosnippet class="validator-text">padding settings</span></span>';

// Background
$background_settings = get_sub_field('background');
$background_type = $background_settings['background_type'] ?? '';
$background_settings_tag = '';
if ($background_type === 'color' && !empty($background_settings['background_color'])) {
    $background_settings_tag = '<span class="background" style="background-color:' . esc_attr($background_settings['background_color']) . '"><span class="validator-text">background settings</span></span>';
} elseif ($background_type === 'image' && !empty($background_settings['background_image']['url'])) {
    $bg_url = $background_settings['background_image']['url'];
    $bg_position = $background_settings['background_image_position'] ?? '';
    if (!empty($background_settings['include_overlay']) && !empty($background_settings['overlay_color'])) {
        $background_settings_tag = '<span class="background" style="background-image:url(' . esc_url($bg_url) . '); --overlay-color:' . esc_attr($background_settings['overlay_color']) . '" data-background-overlay="true" data-background-image-position="' . esc_attr($bg_position) . '"><span class="validator-text">background settings</span></span>';
    } else {
        $background_settings_tag = '<span class="background" style="background-image:url(' . esc_url($bg_url) . ')" data-background-image-position="' . esc_attr($bg_position) . '"><span class="validator-text">background settings</span></span>';
    }
}

// Decide if we have content to show
$has_sections = $add_toggle_sections && $toggles_sections && is_array($toggles_sections);
$has_flat_toggles = !$add_toggle_sections && $toggles && is_array($toggles);

if ($has_sections || $has_flat_toggles) :
    echo $opening_tag;
?>
    <?php if ($has_sections) : ?>
        <?php foreach ($toggles_sections as $section) :
            $section_title = $section['title'] ?? '';
            $section_intro = $section['intro_content'] ?? '';
            $section_image = $section['image'] ?? '';
            $section_toggles = $section['toggles'] ?? [];
            if (empty($section_toggles)) {
                continue;
            }
        ?>
            <div class="toggles__section">
                <?php if ($section_title) : ?>
                    <header class="intro-content-row">
                        <div class="container" data-flex="flex" data-gap="large" <?= $text_color_attribute ?>>
                            <!-- <h2><?= esc_html($section_title) ?></h2> -->
                            <?php if ($section_intro) : ?>
                                <div class="intro-content"><?= wp_kses_post($section_intro) ?></div>
                            <?php endif; ?>
                            <?php if ($section_image) : ?>
                                <picture class="section-image">
                                    <img src="<?= esc_url($section_image['url']) ?>" alt="<?= esc_attr($section_image['alt']) ?>">
                                </picture>
                            <?php endif; ?>
                            <span class=" container-settings" data-container-width="<?= esc_attr($container_width) ?>">
                                <span class="validator-text" data-nosnippet>settings</span>
                            </span>
                        </div>
                    </header>
                <?php elseif ($section_intro) : ?>
                    <header class="intro-content-row">
                        <div class="container" <?= $text_color_attribute ?>>
                            <div class="intro-content"><?= wp_kses_post($section_intro) ?></div>
                            <span class="container-settings" data-container-width="<?= esc_attr($container_width) ?>">
                                <span class="validator-text" data-nosnippet>settings</span>
                            </span>
                        </div>
                    </header>
                <?php endif; ?>
                <div class="toggles__container container">
                    <span class="container-settings" data-container-width="<?= esc_attr($container_width) ?>">
                        <span class="validator-text">settings</span>
                    </span>
                    <?php foreach ($section_toggles as $toggle) : ?>
                        <div class="toggle">
                            <button type="button" class="toggle__trigger" aria-expanded="false">
                                <span class="toggle__trigger-text screenreader-only" data-show="display" data-hide="collapse"></span>
                                <?= esc_html($toggle['title'] ?? '') ?>
                                <span class="toggle__trigger-icon" aria-hidden="true"></span>
                            </button>
                            <div class="toggle__box" aria-hidden="true" <?= $text_color_attribute ?>>
                                <?= wp_kses_post($toggle['content'] ?? '') ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <?php if ($intro_content) : ?>
            <header class="intro-content-row">
                <div class="container" <?= $text_color_attribute ?>>
                    <div class="intro-content"><?= wp_kses_post($intro_content) ?></div>
                    <span class="container-settings" data-container-width="<?= esc_attr($container_width) ?>">
                        <span class="validator-text" data-nosnippet>settings</span>
                    </span>
                </div>
            </header>
        <?php endif; ?>
        <div class="toggles__container container">
            <span class="container-settings" data-container-width="<?= esc_attr($container_width) ?>">
                <span class="validator-text">settings</span>
            </span>
            <?php foreach ($toggles as $toggle) : ?>
                <div class="toggle">
                    <button type="button" class="toggle__trigger" aria-expanded="false">
                        <span class="toggle__trigger-text screenreader-only" data-show="display" data-hide="collapse"></span>
                        <?= esc_html($toggle['title'] ?? '') ?>
                        <span class="toggle__trigger-icon" aria-hidden="true"></span>
                    </button>
                    <div class="toggle__box" aria-hidden="true" <?= $text_color_attribute ?>>
                        <?= wp_kses_post($toggle['content'] ?? '') ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <span class="module-settings">
        <?= $padding_settings_tag ?>
        <?= $background_settings_tag ?>
    </span>
<?php
    echo $closing_tag;
endif;
?>