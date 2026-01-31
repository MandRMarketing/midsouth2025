<?php
$post_id = $args['id'];
$post_permalink = get_the_permalink($post_id);
$post_title = get_the_title($post_id);
$post_date = get_the_date('F j, Y', $post_id);
$post_date_datetime_format = get_the_date('Y-m-d', $post_id);
?>
<li>
    <div class="card">
        <div class="card-content">
            <h3><a href="<?= esc_url($post_permalink) ?>"><?= esc_html($post_title) ?></a></h3>
            <p>Published On: <time datetime="<?= esc_attr($post_date_datetime_format) ?>"><?= esc_html(get_the_date('m-d-Y', $post_id)) ?></time></p>
            <?php
            echo get_template_part('views/conditional/posts/widgets/post-meta/post-category-list', null, array('id' => $post_id));
            ?>
        </div>
        <a href="<?= esc_url($post_permalink) ?>" class="card-arrow" aria-label="Read article"></a>
    </div>
</li>