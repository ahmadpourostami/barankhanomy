<?php
get_header();
if ( have_posts() ) :
    echo '<main class="bk-section"><div class="bk-container">';
    while ( have_posts() ) : the_post();
        echo '<article class="bk-review"><h1>' . esc_html( get_the_title() ) . '</h1>';
        the_content();
        echo '</article>';
    endwhile;
    echo '</div></main>';
else:
    echo '<main class="bk-section"><div class="bk-container"><p>محتوایی پیدا نشد.</p></div></main>';
endif;
get_footer();
