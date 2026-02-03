<?php
$posts_archive_page_id = get_option('page_for_posts');
if ($posts_archive_page_id) :
?>
    <nav class="breadcrumbs">
        <a href="<?= get_the_permalink($posts_archive_page_id); ?>">
            &lt; Back to <?= get_the_title($posts_archive_page_id); ?>
        </a>
        <?php
        // Display linked post categories if they exist
        $categories = get_the_category();
        if (! empty($categories)) :
        ?>
            <span class="post-categories">
                <?php foreach ($categories as $index => $category) : ?>
                    <a href="<?= esc_url(get_category_link($category->term_id)); ?>">
                        <?= esc_html($category->name); ?>
                    </a><?= $index < count($categories) - 1 ? '  | ' : ''; ?>
                <?php endforeach; ?>
            </span>
        <?php endif; ?>
    </nav>
<?php
endif;
?>