<?php
//In this particular case, we're using a title-area.php file that is customized for the Blog because the M&R Master Theme's design calls for the inclusion of a filter form here.

//The global title-area.php file does include code that considers the blog
?>
<header class="title-area">
    <div class="container">
        <?= get_field('blog_intro', get_option('page_for_posts')) ?>
        <span
            class="container-settings"
            data-container-width="standard"
            data-flex="flex"
            data-flex-wrap="wrap"
            data-justify-content="space-between"
            data-align-items="center">
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
</header>