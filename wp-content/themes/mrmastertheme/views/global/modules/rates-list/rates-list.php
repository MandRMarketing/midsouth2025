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
    $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="rates-list ' . $module_class_names . '">';
} else if ($module_id && !$module_class_names) {
    $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="rates-list">';
} else if (!$module_id && $module_class_names) {
    $opening_tag = '<' . $tag_type . ' class="rates-list ' . $module_class_names . '">';
} else {
    $opening_tag = '<' . $tag_type . ' class="rates-list">';
}

//grab the top & bottom padding settings values, for both desktop & mobile
$padding_settings = get_sub_field('padding');
$top_padding_desktop = $padding_settings['top_padding_desktop'];
$bottom_padding_desktop = $padding_settings['bottom_padding_desktop'];
$top_padding_mobile = $padding_settings['top_padding_mobile'];
$bottom_padding_mobile = $padding_settings['bottom_padding_mobile'];

//build out the padding settings <span> HTML:
$padding_settings_tag = '<span class="padding" data-top-padding-desktop="' . $top_padding_desktop . '" data-bottom-padding-desktop="' . $bottom_padding_desktop . '" data-top-padding-mobile="' . $top_padding_mobile . '" data-bottom-padding-mobile="' . $bottom_padding_mobile . '"><span class="validator-text" data-nosnippet>padding settings</span></span>';

//grab the container width from settings
$container_width = get_sub_field('container_width');

//declare variables for content
$intro_content = get_sub_field('intro_content');
$rates = get_sub_field('rates');

//we're only generating HTML if the module has rates to display
if ($rates) :
    echo $opening_tag;
?>
    <?php if ($intro_content) : ?>
        <div class="intro-content-row">
            <div class="container">
                <?= $intro_content ?>
                <span class="container-settings" data-container-width="<?= $container_width ?>">
                    <span class="validator-text" data-nosnippet>settings</span>
                </span>
            </div>
        </div>
    <?php endif; ?>
    <div class="rates-container container">
        <div class="rates-list">
            <?php
            foreach ($rates as $rate) :
                $rate_pretext = $rate['pretext'];
                $rate_number = $rate['rate_#'];
                $rate_type = $rate['rate_type'];
                $rate_link_text = $rate['link_text'];
                $rate_link = $rate['link'];
            ?>
                <div class="rate-item">
                    <?php if ($rate_pretext) : ?>
                        <span class="rate-pretext"><?= $rate_pretext ?></span>
                    <?php endif; ?>
                    <?php if ($rate_number !== '') : ?>
                        <span class="rate-number"><?= number_format($rate_number, 2) ?>%</span>
                    <?php endif; ?>
                    <?php if ($rate_type) : ?>
                        <span class="rate-type"><?= $rate_type ?></span>
                    <?php endif; ?>
                    <?php if ($rate_link && $rate_link_text) : ?>
                        <a href="<?= esc_url($rate_link) ?>" class="rate-link button"><?= $rate_link_text ?></a>
                    <?php endif; ?>
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
        <span class="validator-text">module settings</span>
    </span>
<?php
    echo $closing_tag;
endif;
?>
