<?php
// We only want the featured posts to display on the posts archive page 1, not on any subsequent pages or filter form results:
$featured_posts = get_field('featured_posts', get_option('page_for_posts'));

if (
    !is_paged() &&
    !isset($_GET['post-category']) &&
    !isset($_GET['post-tags']) &&
    !isset($_GET['post-date']) &&
    $featured_posts &&
    is_array($featured_posts)
) :
    $section_title = count($featured_posts) === 1 ? 'Featured Article' : 'Featured Articles';
?>
    <section class="featured-post">
        <div class="container">
            <h4> <?= esc_html($section_title) ?></h4>
            <?php foreach ($featured_posts as $featured_post) :
                $post_id = is_object($featured_post) ? $featured_post->ID : (int) $featured_post;
                $post_image_id = get_post_thumbnail_id($post_id);

                if ($post_image_id) {
                    $post_listing_column_count = 'two';
                    $post_image_size_name = 'medium-square';
                    $post_image_url = wp_get_attachment_image_url($post_image_id, $post_image_size_name);
                    $post_image_width = wp_get_attachment_image_src($post_image_id, $post_image_size_name)[1];
                    $post_image_height = wp_get_attachment_image_src($post_image_id, $post_image_size_name)[2];
                    $post_image_alt = get_post_meta($post_image_id, '_wp_attachment_image_alt', TRUE);
                } else {
                    $post_listing_column_count = 'one';
                    $post_image_url = $post_image_width = $post_image_height = $post_image_alt = null;
                }

                $post_title = get_the_title($post_id);
                $post_date = get_the_date('F j, Y', $post_id);
                $post_date_datetime_format = get_the_date('Y-m-d', $post_id);
                $post_author_id = get_post_field('post_author', $post_id);
                $post_author_name = get_the_author_meta('display_name', $post_author_id);
                $post_excerpt = get_the_excerpt($post_id) ?: null;
            ?>
                <article>
                    <div class="content-row">
                        <div class="columns">
                            <?php if ($post_image_id) : ?>
                                <div
                                    class="column left one-third"
                                    data-mobile-hide="true">
                                    <figure>
                                        <a href="<?= get_the_permalink($post_id) ?>">
                                            <img src="<?= esc_url($post_image_url) ?>" height="<?= esc_attr($post_image_height) ?>" width="<?= esc_attr($post_image_width) ?>" alt="<?= esc_attr($post_image_alt) ?>">
                                        </a>
                                    </figure>
                                </div>
                                <div class="column right two-thirds">
                                    <h3><a href="<?= get_the_permalink($post_id) ?>"><?= esc_html($post_title) ?></a></h3>
                                    <time datetime="<?= esc_attr($post_date_datetime_format) ?>"><?= esc_html($post_date) ?></time>
                                    <span class="author">Author: <?= esc_html($post_author_name) ?></span>
                                    <figure data-desktop-hide="true">
                                        <a href="<?= get_the_permalink($post_id) ?>">
                                            <img src="<?= esc_url($post_image_url) ?>" height="<?= esc_attr($post_image_height) ?>" width="<?= esc_attr($post_image_width) ?>" alt="<?= esc_attr($post_image_alt) ?>">
                                        </a>
                                    </figure>
                                    <?php if ($post_excerpt) : ?>
                                        <blockquote class="excerpt" cite="<?= esc_url(get_the_permalink($post_id)) ?>">
                                            <?= wp_kses_post($post_excerpt) ?>
                                        </blockquote>
                                    <?php endif; ?>
                                    <?php
                                    echo get_template_part('views/conditional/posts/widgets/post-meta/post-category-list', null, array('id' => $post_id));
                                    echo get_template_part('views/conditional/posts/widgets/post-meta/post-tag-list', null, array('id' => $post_id));
                                    ?>
                                    <a href="<?= get_the_permalink($post_id) ?>" class="button">Read Article</a>
                                </div>
                            <?php else : ?>
                                <div class="column">
                                    <h3><a href="<?= get_the_permalink($post_id) ?>"><?= esc_html($post_title) ?></a></h3>
                                    <time datetime="<?= esc_attr($post_date_datetime_format) ?>"><?= esc_html($post_date) ?></time>
                                    <span class="author">Author: <?= esc_html($post_author_name) ?></span>
                                    <?php if ($post_excerpt) : ?>
                                        <blockquote class="excerpt" cite="<?= esc_url(get_the_permalink($post_id)) ?>">
                                            <?= wp_kses_post($post_excerpt) ?>
                                        </blockquote>
                                    <?php endif; ?>
                                    <?php
                                    echo get_template_part('views/conditional/posts/widgets/post-meta/post-category-list', null, array('id' => $post_id));
                                    echo get_template_part('views/conditional/posts/widgets/post-meta/post-tag-list', null, array('id' => $post_id));
                                    ?>
                                    <a href="<?= get_the_permalink($post_id) ?>" class="button">Read Article</a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <span
                            class="row-settings"
                            data-column-count="<?= esc_attr($post_listing_column_count) ?>"
                            data-column-width="variable">
                            <span class="validator-text" data-nosnippet>row settings</span>
                        </span>
                    </div>
                </article>
            <?php endforeach; ?>
            <span
                class="container-settings"
                data-container-width="standard">
                <span class="validator-text" data-nosnippet>settings</span>
            </span>
        </div>
        <span
            class="padding"
            data-top-padding-desktop="double"
            data-bottom-padding-desktop="double"
            data-top-padding-mobile="single"
            data-bottom-padding-mobile="single">
            <span class="validator-text" data-nosnippet>padding settings</span>
        </span>
    </section>
<?php
endif;
?>