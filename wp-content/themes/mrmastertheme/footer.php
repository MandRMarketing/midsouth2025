<?php
//The Events Calendar plugin's options for customizing their templates creates a conflict with our new M&R theme directory structure. So, we'd like to avoid customizing templates their way unless absolutely necessary. By default, their views lack a <main> tag, which is essential for our <header>'s fixed styling. We call a function based on post type that will open the <main> in header.php, & close it here:
if (get_post_type() === 'tribe_events') {
    mandr_close_semantic_main_tag();
}
?>
<footer>
    <?php
    //Unlike the site's header, the footer is something you'll likely have to build from scratch for each site project:

    //Use the existing column system, widget(s), menu structure, etc. to make this process as quick as possible
    ?>
    <div class="content-row contact-info-row">
        <div class="columns">
            <div class="column">
                <?php
                //Site Logo with Home Link widget:
                get_template_part('views/global/widgets/site-logo-home-link/site-logo-home-link-alt');

                ?>
            </div>
            <div class="column routing-number">
                <h4>Routing<br>Number</h4>
                <p><?= get_field('contact_info_routing_number', 'options') ?></p>
            </div>
            <div class="column">
                <?php
                //Quicklinks widget:
                get_template_part('views/global/footer/navigation/quicklinks/quicklinks');
                ?>
            </div>
            <div class="column">
                <h4 class="download-app-title">Download Our <br>Mobile App</h4>
                <div class="app-links">
                    <?= do_shortcode('[google-play]'); ?>
                    <?= do_shortcode('[apple-appstore]'); ?>
                </div>
            </div>
        </div>
        <span
            class="row-settings"
            data-column-count="four"
            data-container-width="standard">
            <span class="validator-text" data-nosnippet>row settings</span>
        </span>
    </div>
    <div class="content-row certifications-row">
        <div class="columns">
            <?php
            foreach (get_field('certifications', 'options') as $certification) :
                $icon = $certification['icon'];
                $description = $certification['description'];
            ?>
                <div class="column" data-flex="flex" data-align-items="center" data-justify-content="center">
                    <img src="<?= $icon['url'] ?>" alt="<?= $icon['alt'] ?>">
                    <?= $description ?>
                </div>
            <?php endforeach; ?>
        </div>
        <span
            class="row-settings"
            data-column-count="three"
            data-container-width="standard">
            <span class="validator-text" data-nosnippet>row settings</span>
        </span>
    </div>
    <div class="copyright-row content-row">
        <div class="columns">
            <div class="column">
                <div class="copyright-text">
                    <?= get_field('copyright_info', 'options') ?>
                </div>
            </div>
            <div class="column">
                <?php
                //Social Media Icons widget:
                get_template_part('views/global/widgets/social-media-icons/social-media-icons');
                ?>
            </div>
        </div>
        <span
            class="row-settings"
            data-column-count="two"
            data-container-width="standard">
            <span class="validator-text" data-nosnippet>row settings</span>
        </span>
    </div>
</footer>

<?php wp_footer(); ?>

</body>

</html>