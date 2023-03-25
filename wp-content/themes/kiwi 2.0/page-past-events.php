<?php get_header();

pageBanner(array(
  'title' => 'Past Events',
  'subtitle' => 'A recap of our past events.'
));
?>

<div class="container container--narrow page-section">

  <!-- Add posts -->
  <!-- Do something once for each blog post -->
  <?php
    $today = date('Ymd');
    $pastEvents = new WP_Query(array(
        // paged is for pagination
        'paged' => get_query_var('paged', 1),
        'post_type' => 'event',
        'meta_key' => 'event_date',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'meta_query' => array(
            'key' => 'event_date',
            'compare' => '<=',
            'value' => $today,
            'type' => 'numeric'
        )
    ));

  while($pastEvents->have_posts()) {
    $pastEvents->the_post();
    get_template_part('template-parts/event');  
  }
  
  // Add pagination
  echo paginate_links(array(
    'total' => $pastEvents->max_num_pages
  ));
  ?>
</div>


<?php
get_footer();
?>