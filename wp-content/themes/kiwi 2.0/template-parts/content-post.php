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