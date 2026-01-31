<?php
$post_id = $args['id'];

if (get_the_terms($post_id, 'category')) {
    $post_categories = get_the_terms($post_id, 'category');
} else {
    $post_categories = false;
}

if ($post_categories) :
?>
    <span class="post-categories">
        <?php
        $first = true;
        foreach ($post_categories as $category) :
            $category_id = $category->term_id;
            $category_name = $category->name;
            if (!$first) {
                echo ' | ';
            }
            $first = false;
        ?>
            <a href="<?= esc_url(get_term_link($category_id)) ?>"><?= esc_html($category_name) ?></a>
        <?php
        endforeach;
        ?>
    </span>
<?php
endif;
?>
