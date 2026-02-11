<?php
get_header();
?>
<main id="main" class="primary-content">
    <?php get_template_part('views/global/title-area/title-area'); ?>
    <section class="search-results">
        <div class="container">
            <?php if (have_posts()) : ?>
                <ul class="posts posts-grid" data-grid="grid" data-row-gap="small" data-column-gap="small" data-column-count="one">
                    <?php while (have_posts()) : the_post(); ?>
                        <li>
                            <div class="card">
                                <div class="card-content">
                                    <h3><a href="<?= get_the_permalink(); ?>"><?= get_the_title(); ?></a></h3>
                                    <p><?= get_the_excerpt(); ?></p>
                                    <a href="<?= get_the_permalink(); ?>" class="read-more">Read More</a>
                                </div>
                                <a href="<?= get_the_permalink(); ?>" class="card-arrow" aria-label="View <?= esc_attr(get_the_title()); ?>"></a>
                            </div>
                        </li>
                    <?php endwhile; ?>
                </ul>
                <?php
                the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => '&lt;',
                    'next_text' => '&gt;',
                ));
                ?>
            <?php else : ?>
                <div class="no-results">
                    <h3>No results found for "<?= esc_html(get_search_query()); ?>"</h3>
                    <p>Please try a different search term.</p>
                </div>
            <?php endif; ?>
            <span class="container-settings" data-container-width="standard">
                <span class="validator-text" data-nosnippet>settings</span>
            </span>
        </div>
        <span class="padding" data-top-padding-desktop="double" data-bottom-padding-desktop="double" data-top-padding-mobile="single" data-bottom-padding-mobile="single">
            <span class="validator-text" data-nosnippet>padding settings</span>
        </span>
    </section>
</main>
<?php
get_footer();
?>
