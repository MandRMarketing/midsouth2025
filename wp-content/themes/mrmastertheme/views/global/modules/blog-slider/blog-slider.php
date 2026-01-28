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
    $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="blog-slider ' . $module_class_names . '">';
} else if ($module_id && !$module_class_names) {
    $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="blog-slider">';
} else if (!$module_id && $module_class_names) {
    $opening_tag = '<' . $tag_type . ' class="blog-slider ' . $module_class_names . '">';
} else {
    $opening_tag = '<' . $tag_type . ' class="blog-slider">';
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
$articles = get_sub_field('articles');

//we're only generating HTML if the module has articles to display
if ($articles) :
    echo $opening_tag;
    //prevent duplicate IDs when multiple sliders exist on the same page
    $random_integer = rand(0, 999);
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
    <div id="blog-carousel-<?= $random_integer; ?>" class="blog-carousel-row container">
        <?php
        foreach ($articles as $article) :
            $article_id = $article->ID;
            $article_link = get_permalink($article_id);
            $article_title = get_the_title($article_id);
            $article_excerpt = get_the_excerpt($article_id);
            $article_date = get_the_date('', $article_id);

            $article_image_size_name = 'full';
            $article_image_id = get_post_thumbnail_id($article_id);
            $article_image_url = '';
            $article_image_width = '';
            $article_image_height = '';
            $article_image_alt = '';

            if ($article_image_id) {
                $article_image_url = wp_get_attachment_image_url($article_image_id, $article_image_size_name);
                $article_image_width = wp_get_attachment_image_src($article_image_id, $article_image_size_name)[1];
                $article_image_height = wp_get_attachment_image_src($article_image_id, $article_image_size_name)[2];
                $article_image_alt = get_post_meta($article_image_id, '_wp_attachment_image_alt', true);
            }
        ?>
            <div class="blog-slide">
                <?php if ($article_image_id) : ?>
                    <figure>
                        <a href="<?= $article_link ?>">
                            <img
                                src="<?= $article_image_url ?>"
                                height="<?= $article_image_height ?>"
                                width="<?= $article_image_width ?>"
                                alt="<?= $article_image_alt ?>">
                        </a>
                    </figure>
                <?php endif; ?>
                <div class="blog-content">
                    <?php if ($article_date) : ?>
                        <time class="blog-date" datetime="<?= get_the_date('c', $article_id) ?>"><?= $article_date ?></time>
                    <?php endif; ?>
                    <h3 class="blog-title">
                        <a href="<?= $article_link; ?>"><?= $article_title; ?></a>
                    </h3>
                    <?php if ($article_excerpt) : ?>
                        <p class="blog-excerpt"><?= $article_excerpt ?></p>
                    <?php endif; ?>
                    <a href="<?= $article_link; ?>" class="button">Read More</a>
                </div>
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
            jQuery('#blog-carousel-<?= $random_integer ?>').slick({
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
                slide: '.blog-slide',
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