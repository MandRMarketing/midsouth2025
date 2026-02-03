<article id="post-<?php the_ID(); ?>">
    <?php
    //Title Area (specific to single posts):
    echo get_template_part('views/conditional/posts/single/title-area/title-area');

    //Global Modules
    echo get_template_part('views/global/modules/modules');

    ?>
    <?php
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