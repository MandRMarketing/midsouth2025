<?php
if (have_rows('modules')) :
    while (have_rows('modules')) :
        the_row();
        //Standard Content Module 
        if (get_row_layout() == 'standard_content') :
            get_template_part('views/global/modules/standard-content/standard-content');

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

        //Table
        elseif (get_row_layout() == 'table') :
            get_template_part('views/global/modules/table/table');

        //Toggles
        elseif (get_row_layout() == 'toggles') :
            get_template_part('views/global/modules/toggles/toggles');

        endif;

    endwhile;
endif; // end have(layouts) check