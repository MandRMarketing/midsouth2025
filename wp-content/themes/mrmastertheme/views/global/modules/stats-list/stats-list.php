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
$stats = get_sub_field('stats');

//we're only generating HTML if the module has rates to display
if ($stats) :
    echo $opening_tag;
?>
    <div class="rates-container container">
        <?php if ($intro_content) : ?>
            <div class="intro-content">
                <?= $intro_content ?>
            </div>
        <?php endif; ?>
        <div class="rates-list">
            <?php
            foreach ($stats as $stat) :
                $stat_pretext = $stat['pretext'];
                $stat_number = $stat['stat_#'];
                $stat_posttext = $stat['post_text'];
            ?>
                <div class="stat-item">
                    <?php if ($stat_pretext) : ?>
                        <span class="stat-pretext"><?= $stat_pretext ?></span>
                    <?php endif; ?>
                    <div class="stat-number-container">
                        <?php if ($stat_number !== '') : ?>
                            <span class="stat-number" data-stat-value="<?= esc_attr((float) $stat_number) ?>"><?= $stat_number ?></span>
                        <?php endif; ?>
                    </div>
                    <?php if ($stat_posttext) : ?>
                        <span class="stat-posttext"><?= $stat_posttext ?></span>
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