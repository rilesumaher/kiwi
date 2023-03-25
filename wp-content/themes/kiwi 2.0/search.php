<?php
get_header();

pageBanner(array(
  'title' => 'Search results',
  'subtitle' => 'You searched for &ldquo;' . esc_html(get_search_query(false)) . '&rdquo;'
)); ?>

<div class="container container--narrow page-section">

<?php
    if(have_posts()) {
        while(have_posts()) {
            echo '<hr><div style="padding-bottom: 20px; padding-top: 10px">';
            the_post(); 
            get_template_part('template-parts/content', get_post_type());
            echo '</div>';
        }
    } else {
        echo '<h2>No results match your search.</h2>';
    }

    get_search_form();
  
  // Add pagination
  echo paginate_links();
?>
</div>

<?php get_footer(); ?>