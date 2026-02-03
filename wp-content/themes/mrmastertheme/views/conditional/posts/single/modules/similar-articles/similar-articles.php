<?php
$curent_post_id = get_the_id();

//first, we grab the categories and tags applied to the current post:
if (get_the_terms($curent_post_id, 'category')) {
    $post_categories = get_the_terms($curent_post_id, 'category');
} else {
    $post_categories = false;
}

if (get_the_terms($curent_post_id, 'post_tag')) {
    $post_tags = get_the_terms($curent_post_id, 'post_tag');
} else {
    $post_tags = false;
}

//declare an empty arguments array, for us to fill if any categories or tags are applied to the current post:
$args = [];

//grab the post category filter if used:
if ($post_categories) {
    //initialize tax_query key in $args if it hasn't already:
    if (!in_array('tax_query', $args)) {
        $args['tax_query'] = [];
    }

    //declare empty array to hold all category IDs
    $post_category_array = [];

    //loop through the categories, push each ID to the category array
    foreach ($post_categories as $category) {
        array_push($post_category_array, $category->term_id);
    }

    //push the category array to the arguments array
    array_push(
        $args['tax_query'],
        array(
            'taxonomy' => 'category',
            'terms' => array(
                $post_category_array
            ),
        )
    );
}

//grab the post tags filter if used:
if ($post_tags) {
    //initialize tax_query key in $args if it hasn't already:
    if (!in_array('tax_query', $args)) {
        $args['tax_query'] = [];
    }

    //initialize an array to hold the tag IDs
    $post_tag_array = [];

    //loop through the tags, push each ID to the category array
    foreach ($post_tags as $tag) {
        array_push($post_tag_array, $tag->term_id);
    }

    array_push(
        $args['tax_query'],
        array(
            'taxonomy' => 'post_tag',
            'terms' => $post_tag_array
        )
    );
}

//if both the category & tags filters are used, add the 'relation' parameter to combine the 2 queries:
if ($post_categories && $post_tags) {
    $args['tax_query']['relation'] = 'OR';
}

//push 'per page' count to the arguments array:
$args['posts_per_page'] = 6;

//exclude the current post:
$args['post__not_in'] = [$curent_post_id];

//we're only going to use this module if either a category or tag is applied to the current post:
if ($post_categories || $post_tags) :

    //use the $args to query similar posts:
    $post_query = new WP_Query($args);

    if ($post_query->have_posts()) :
        // Match blog-slider layout: manual values (no ACF)
        $tag_type = 'section';
        $opening_tag = '<' . $tag_type . ' class="blog-slider similar-articles">';
        $closing_tag = '</' . $tag_type . '>';

        $container_width = 'standard';

        $top_padding_desktop = 'none';
        $bottom_padding_desktop = 'double';
        $top_padding_mobile = 'none';
        $bottom_padding_mobile = 'single';
        $padding_settings_tag = '<span class="padding" data-top-padding-desktop="' . $top_padding_desktop . '" data-bottom-padding-desktop="' . $bottom_padding_desktop . '" data-top-padding-mobile="' . $top_padding_mobile . '" data-bottom-padding-mobile="' . $bottom_padding_mobile . '"><span class="validator-text" data-nosnippet>padding settings</span></span>';

        $articles = $post_query->posts;
        $random_integer = rand(0, 999);
        echo $opening_tag;
?>
        <div class="intro-content-row">
            <div class="container">
                <div class="content-wrapper">
                    <h2 class="title">Similar Articles</h2>
                    <p>Stay on top of your financial health and wellness with industry news brought to you by the experts.</p>
                    <a href="<?= get_the_permalink(get_option('page_for_posts')) ?>" class="button" data-mobile-hide="true">View All Articles</a>
                </div>
                <span class="container-settings" data-container-width="<?= $container_width ?>">
                    <span class="validator-text" data-nosnippet>settings</span>
                </span>
            </div>
        </div>
        <div class="slick-wrapper">
            <div id="blog-carousel-arrows-<?= $random_integer; ?>" class="slider-arrows container">
                <!-- Slick arrows will be appended here -->
            </div>
            <div id="blog-carousel-<?= $random_integer; ?>" class="blog-carousel-row container">
                <?php
                foreach ($articles as $article) :
                    $article_id = $article->ID;
                    $article_link = get_permalink($article_id);
                    $article_title = get_the_title($article_id);
                    $article_featured_image = get_the_post_thumbnail_url($article_id, 'full');
                    $article_featured_image_alt = get_post_meta(get_post_thumbnail_id($article_id), '_wp_attachment_image_alt', true);
                ?>
                    <div class="blog-slide">
                        <figure class="blog-image <?= !$article_featured_image ? 'blog-image--fallback' : '' ?>">
                            <a href="<?= $article_link ?>">
                                <?php if ($article_featured_image) : ?>
                                    <img
                                        src="<?= $article_featured_image ?>"
                                        alt="<?= esc_attr($article_featured_image_alt) ?>">
                                <?php else : ?>
                                    <img
                                        src="/wp-content/themes/mrmastertheme/library/custom-theme/images/logos/logo.svg"
                                        alt="<?= esc_attr(get_bloginfo('name')) ?>">
                                <?php endif; ?>
                            </a>
                        </figure>
                        <div class="blog-content">
                            <h4 class="blog-title">
                                <a href="<?= $article_link; ?>"><?= $article_title; ?></a>
                            </h4>
                            <a href="<?= $article_link; ?>" class="button button--clear">Read Article</a>
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
        </div>
        <span class="slider-settings">
            <script>
                jQuery('#blog-carousel-<?= $random_integer ?>').slick({
                    arrows: true,
                    appendArrows: '#blog-carousel-arrows-<?= $random_integer ?>',
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
                    slidesToShow: 3,
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
        wp_reset_postdata();
    endif;
endif;
?>