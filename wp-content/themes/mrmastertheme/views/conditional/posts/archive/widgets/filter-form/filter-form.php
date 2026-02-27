<?php
//first, let's grab all the filter terms:
$post_categories = get_terms(array('taxonomy' => 'category', 'hide_empty' => false));
$post_tags = get_terms(array('taxonomy' => 'post_tag', 'hide_empty' => false));

//to get the archive to work in conjunction with categories & tags is a bit tricky:
//grab ALL the posts, but only return IDs to keep query lite
$archive_query = new WP_Query(array('post_type' => 'post', 'posts_per_page' => -1, 'fields' => 'ids'));

if ($archive_query->have_posts()) {
    $post_archives = true;

    // Collect unique years from all posts
    $years_array = [];
    foreach ($archive_query->posts as $post_id) {
        $post_year = get_the_date($format = 'Y', $post = $post_id);
        if ($post_year && !in_array($post_year, $years_array)) {
            $years_array[] = $post_year;
        }
    }
    rsort($years_array); // Newest first
} else {
    $post_archives = false;
}

//reset post data since we just queried
wp_reset_postdata();

// Pre-select category when viewing a category archive
$preselected_category = null;
if (isset($_GET['post-category'])) {
    $preselected_category = (int) $_GET['post-category'];
} elseif (is_category()) {
    $queried = get_queried_object();
    if ($queried && isset($queried->term_id)) {
        $preselected_category = (int) $queried->term_id;
    }
}

if ($post_categories || $post_tags || $post_archives) :
?>
    <form
        role="search"
        action="<?= get_the_permalink(get_option('page_for_posts')) ?>"
        id="post-filters">
        <ul
            class="form-fields"
            data-flex="flex"
            data-flex-wrap="wrap"
            data-justify-content="space-between"
            data-align-items="center">
            <?php
            if ($post_categories) :
                //I'm not the biggest fan of the ternary operator, but what we're doing here with it is saving some space while handling some UX work.

                //If a category isn't used in the search, default to the placeholder option. If a category is used, ensure it's pre-selected when the page loads.
            ?>
                <li class="post-category-filter">
                    <select name="post-category" id="post-category">
                        <option
                            <?= ($preselected_category === null) ? 'selected' : ''; ?>
                            disabled>
                            Category
                        </option>
                        <?php
                        foreach ($post_categories as $category) :
                        ?>
                            <option
                                value="<?= $category->term_id ?>"
                                <?= ($preselected_category === (int) $category->term_id) ? 'selected' : ''; ?>>
                                <?= $category->name ?>
                            </option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </li>

            <?php
            endif;

            if ($post_archives) :
            ?>
                <li class="post-date-filter">
                    <select name="post-date" id="post-date">
                        <option
                            <?= (!isset($_GET['post-date'])) ? 'selected' : ''; ?>
                            disabled>
                            Date
                        </option>
                        <?php
                        foreach ($years_array as $year) :
                        ?>
                            <option
                                value="<?= esc_attr($year) ?>"
                                <?= (isset($_GET['post-date']) && $_GET['post-date'] === $year) ? 'selected' : ''; ?>>
                                <?= esc_html($year) ?>
                            </option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </li>
            <?php
            endif;
            ?>
            <li class="post-keyword-filter">
                <input
                    type="search"
                    name="post-keyword"
                    id="post-keyword"
                    placeholder="Keyword"
                    value="<?= isset($_GET['post-keyword']) ? esc_attr(sanitize_text_field(wp_unslash($_GET['post-keyword']))) : ''; ?>"
                    aria-label="Search posts by keyword">
            </li>
            <li class="post-filter-submit">
                <input class="button" type="submit" value="Search">
            </li>
            <?php
            //if any filters are being used, print a 'clear' button
            if ($preselected_category !== null || isset($_GET['post-tags']) || isset($_GET['post-date']) || (isset($_GET['post-keyword']) && $_GET['post-keyword'] !== '')) :
            ?>
                <li class="post-filter-clear">
                    <a href="<?= get_the_permalink(get_option('page_for_posts')) ?>">Clear Filters</a>
                </li>
            <?php
            endif;
            ?>
        </ul>
    </form>
<?php
endif;
?>