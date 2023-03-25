<?php
get_header();

pageBanner(array(
  'title' => get_the_archive_title(),
  'subtitle' => get_the_archive_description()
));
?>

<div class="container container--narrow page-section">

  <!-- Add posts -->
  <!-- Do something once for each blog post -->
  <?php
  while(have_posts()) {
    the_post(); ?>

      <div class="post-item">
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

        <!-- metabox - a made up class -->
        <div class="metabox">

          <!-- add echo to GET functions -->
          <p>Posted by <?php the_author_posts_link(); ?> on <?php the_time('n.j.y'); ?> in <?php echo get_the_category_list(', '); ?></p>
        </div>

        <div class="generic-content">
          <?php the_excerpt(); ?>
          <p><a class="btn btn--blue" href="<?php the_permalink(); ?>">Read more</a></p>
        </div>
      
      </div>
  <?php }
  
  // Add pagination
  echo paginate_links();
  ?>
</div>


<?php
get_footer();
?>