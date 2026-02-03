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
   <header>

       <div class="container">
           <h1>
               <?php
                if (strlen(get_field('title_area')['page_title']) > 0) {
                    echo get_field('title_area')['page_title'];
                } else {
                    echo get_the_title();
                }
                ?>
           </h1>
           <?php
            //Intro Content:

            if (get_field('title_area')['include_intro_content'] && strlen(get_field('title_area')['intro_content']) > 0) :
            ?>
               <div class="intro-content">
                   <?= get_field('title_area')['intro_content'] ?>
               </div>
           <?php
            endif;
            ?>
           <?php
            //Date info:
            $post_date = get_the_date('F j, Y');
            $post_date_datetime_format = get_the_date('Y-m-d');
            ?>
           <time datetime="<?= $post_date_datetime_format ?>"><?= $post_date ?></time>
           <span
               class="container-settings"
               data-container-width="standard">
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