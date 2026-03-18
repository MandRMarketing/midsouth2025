<article id="post-<?php the_ID(); ?>">
    <?php
    //Title Area (specific to single posts):
    echo get_template_part('views/conditional/posts/single/title-area/title-area');

    //if modules exists
    if (isset($args['id'])) {
        $ID = $args['id'];
    } else {
        $ID = false;
    }

    if (have_rows('modules', $ID)) :

        while (have_rows('modules', $ID)) : the_row();

            //Standard Content Module 
            if (get_row_layout() == 'standard_content') :
                get_template_part('views/global/modules/standard-content/standard-content');

            //Background Start
            elseif (get_row_layout() == 'background_start') :
                get_template_part('views/global/modules/background-start/background-start');

            //Background Stop
            elseif (get_row_layout() == 'background_stop') :
                get_template_part('views/global/modules/background-stop/background-stop');

            //Callout
            elseif (get_row_layout() == 'callout') :
                get_template_part('views/global/modules/callout/callout');

            //Blog Slider
            elseif (get_row_layout() == 'slider_blog') :
                get_template_part('views/global/modules/blog-slider/blog-slider');

            //Curved Top Slider
            elseif (get_row_layout() == 'slider_curved_top') :
                get_template_part('views/global/modules/curved-top-slider/curved-top-slider');

            //Cards
            elseif (get_row_layout() == 'cards') :
                get_template_part('views/global/modules/cards/cards');

            //Cards - Images Hover
            elseif (get_row_layout() == 'cards_images_hover_effect') :
                get_template_part('views/global/modules/cards-images-hover/cards-images-hover');

            //Cards - Links
            elseif (get_row_layout() == 'cards_links') :
                get_template_part('views/global/modules/cards-links/cards-links');

            //Full Width - Card Icons
            elseif (get_row_layout() == 'full_width_card_icons') :
                get_template_part('views/global/modules/full-width-card-icons/full-width-card-icons');

            //Full Width - Two Columns
            elseif (get_row_layout() == 'full_width_two_columns') :
                get_template_part('views/global/modules/full-width-two-columns/full-width-two-columns');

            //History Timeline
            elseif (get_row_layout() == 'history_timeline') :
                get_template_part('views/global/modules/history-timeline/history-timeline');

            //Locations
            elseif (get_row_layout() == 'locations') :
                get_template_part('views/global/modules/locations/locations');

            //Rates List
            elseif (get_row_layout() == 'rates_list') :
                get_template_part('views/global/modules/rates-list/rates-list');

            // Stats List
            elseif (get_row_layout() == 'stats_list') :
                get_template_part('views/global/modules/stats-list/stats-list');

            //Table
            elseif (get_row_layout() == 'table') :
                get_template_part('views/global/modules/table/table');

            //Toggles
            elseif (get_row_layout() == 'toggles') :
                get_template_part('views/global/modules/toggles/toggles');

            endif;

        endwhile;

    else:
        //if no modules exist, display the content
    ?>
        <section class="section-wrap">
            <div class="container">
                <?php the_content(); ?>
                <span class="container-settings" data-container-width="standard">
                    <span class="validator-text" data-nosnippet>settings</span>
                </span>
            </div>
            <span class="module-settings" data-nosnippet>
                <span class="padding" data-top-padding-desktop="single" data-bottom-padding-desktop="single" data-top-padding-mobile="single" data-bottom-padding-mobile="single">
                    <span class="validator-text" data-nosnippet>padding settings</span>
                </span>
                <span class="validator-text">module settings</span>
            </span>
        </section>
    <?php
    endif;

    //Similar Articles Module (specific to single posts):
    echo get_template_part('views/conditional/posts/single/modules/similar-articles/similar-articles');
    ?>
    <section class="title-area-breadcrumb">
        <div class="container">
            <?php
            //Breadcrumb(s):
            echo get_template_part('views/conditional/posts/single/widgets/breadcrumbs/back-to-archive');
            ?>
            <span
                class="container-settings"
                data-container-width="standard">
                <span class="validator-text" data-nosnippet>settings</span>
            </span>
        </div>
        <span
            class="padding"
            data-top-padding-desktop="single"
            data-bottom-padding-desktop="single"
            data-top-padding-mobile="single"
            data-bottom-padding-mobile="single">
            <span class="validator-text" data-nosnippet>padding settings</span>
        </span>
    </section>
</article>