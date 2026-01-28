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

//grab the container width from settings
$container_width = get_sub_field('container_width');

//declare variables for content
$slides = get_sub_field('slides');

//we're only generating HTML if the module has slides to display
if ($slides) :
    echo $opening_tag;
    //prevent duplicate IDs when multiple sliders exist on the same page
    $random_integer = rand(0, 999);
?>
    <div id="curved-top-slider-<?= $random_integer; ?>" class="curved-top-slider-container container">
        <?php
        foreach ($slides as $slide) :
            $slide_title = $slide['title'];
            $slide_icon = $slide['icon'];
            $slide_header = $slide['header'];
            $slide_subtext = $slide['subtext'];
        ?>
            <div class="slide">
                <?php if ($slide_icon) :
                    $slide_icon_url = $slide_icon['url'];
                    $slide_icon_alt = $slide_icon['alt'] ?: 'icon';
                ?>
                    <figure class="slide-icon">
                        <img
                            src="<?= $slide_icon_url ?>"
                            alt="<?= $slide_icon_alt ?>">
                    </figure>
                <?php endif; ?>
                <?php if ($slide_title) : ?>
                    <h3 class="slide-title"><?= $slide_title ?></h3>
                <?php endif; ?>
                <?php if ($slide_header) : ?>
                    <h4 class="slide-header"><?= $slide_header ?></h4>
                <?php endif; ?>
                <?php if ($slide_subtext) : ?>
                    <p class="slide-subtext"><?= $slide_subtext ?></p>
                <?php endif; ?>
            </div>
        <?php
        endforeach;
        ?>
        <span
            class="container-settings"
            data-container-width="<?= $container_width ?>">
            <span class="validator-text" data-nosnippet>container settings</span>
        </span>
    </div>
    <span class="slider-settings">
        <script>
            jQuery('#curved-top-slider-<?= $random_integer ?>').slick({
                arrows: true,
                autoplay: true,
                dots: false,
                adaptiveHeight: false,
                responsive: [{
                        breakpoint: 1280,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToScroll: 1,
                            slidesToShow: 1,
                        },
                    },
                ],
                rows: 0,
                slide: '.slide',
                slidesToScroll: 1,
                slidesToShow: 4,
            });
        </script>
        <span class="validator-text" data-nosnippet>slider settings</span>
    </span>
    <span class="module-settings" data-nosnippet>
        <?= $padding_settings_tag ?>
        <span class="validator-text">module settings</span>
    </span>
<?php
    echo $closing_tag;
endif;
?>