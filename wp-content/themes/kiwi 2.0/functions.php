<?php
require get_theme_file_path('/inc/search-route.php');
require get_theme_file_path('/inc/like-route.php');

function kiwi_custom_rest() {
  register_rest_field('post', 'authorName', array(
    'get_callback' => function() {
      return get_the_author();
    }));

  register_rest_field('note', 'userNoteCount', array(
    'get_callback' => function() {
      return count_user_posts(get_current_user_id(), 'note');
    }));
}

add_action('rest_api_init', 'kiwi_custom_rest');

function pageBanner($args = NULL) {
  
    if (!isset($args['title'])) {
      $args['title'] = get_the_title();
    }
  
    if (!isset($args['subtitle'])) {
      $args['subtitle'] = get_field('page_banner_subtitle');
    }
  
    if (!isset($args['photo'])) {
        if (get_field('page_banner_background_image') AND !is_archive() AND !is_home()) {
        $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
      } else {
        $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
      }
    }
  
    ?>
    <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>);"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
        <div class="page-banner__intro">
          <p><?php echo $args['subtitle']; ?></p>
        </div>
      </div>  
    </div>
  <?php }

// Add styles and scripts
function kiwi_add_css() {
    wp_enqueue_style( 'style', get_theme_file_uri( '/style.css'), [], wp_rand(), 'all' );
    wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style( 'style-index', get_theme_file_uri( '/build/style-index.css'), [], wp_rand(), 'all' );
    wp_enqueue_style( 'index', get_theme_file_uri( '/build/index.css'), [], wp_rand(), 'all' );
    wp_enqueue_style( 'custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_script( 'main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
    
    // This is a WP function that will let us output JS into the source of the web page
    wp_localize_script('main-university-js', 'universityData', array(
      // root_url is a made up name 
      'root_url' => get_site_url(),
      'nonce' => wp_create_nonce('wp_rest')
    ));
}

add_action( 'wp_enqueue_scripts', 'kiwi_add_css' );

function kiwi_menus() {
    // Create menu in the Appearance
    register_nav_menu('kiwiHeader', 'Kiwi Header Menu');

    // Create footer menu
    register_nav_menu('kiwiFooterOne', 'Kiwi Footer Menu');

    // Create footer menu 2
    register_nav_menu('kiwiImeFooterTwo', 'Kiwi Footer Menu 2');
}

add_action('after_setup_theme', 'kiwi_menus');

function kiwi_theme_support() {
    // Add page tab title
    add_theme_support('title-tag');

    // Add a featured images
    add_theme_support('post-thumbnails');

    // Image sizes, crops images and pulls only these sizes to front end
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);
}

add_action('after_setup_theme', 'kiwi_theme_support');

function kiwi_adjust_queries($query) {
    // Creating a query for the archive-program.php
    if (!is_admin() AND is_post_type_archive('program') AND $query->is_main_query()) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1);
    }

    // Creating a query for the archive-event.php
    if (!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) {
        $today = date('Ymd');
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', array(
            'key' => 'event_date',
            'compare' => '>=',
            'value' => $today,
            'type' => 'numeric'
        ));
    }
}

add_action('pre_get_posts', 'kiwi_adjust_queries');

// Redirect subscriber accounts out of admin and onto home page
function redirectSubsToFrontend() {
  $CurrentUser = wp_get_current_user();
  if(count($CurrentUser->roles) == 1 AND $CurrentUser->roles[0] == 'subscriber') {
    wp_redirect(site_url('/'));
    exit;
  }
}

add_action('admin_init', 'redirectSubsToFrontend');

function noSubsAdminBar() {
  $CurrentUser = wp_get_current_user();
  if(count($CurrentUser->roles) == 1 AND $CurrentUser->roles[0] == 'subscriber') {
    show_admin_bar(false);
  }
}

add_action('wp_loaded', 'noSubsAdminBar');

// Customize login screen
function ourHeaderUrl() {
  return esc_url(site_url('/'));
}

add_filter('login_headerurl', 'ourHeaderUrl');

// Override the wp-login page CSS
function ourLoginCSS() {
  wp_enqueue_style( 'custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
  wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  wp_enqueue_style( 'style-index', get_theme_file_uri( '/build/style-index.css'), [], wp_rand(), 'all' );
  wp_enqueue_style( 'index', get_theme_file_uri( '/build/index.css'), [], wp_rand(), 'all' );
}

add_action('login_enqueue_scripts', 'ourLoginCSS');

// Change the title on the wp-login page
function ourLoginTitle() {
  return get_bloginfo('name');
}

add_filter('login_headertitle', 'ourLoginTitle');

// Force note posts to be private
function makeNotePrivate($data, $postarr) {
  if($data['post_type'] == 'note') {
    if(count_user_posts(get_current_user_id(), 'note') > 4 AND !$postarr['ID']) {
      die("No more than 5 notes are allowed.");
    }

    $data['post_content'] = sanitize_textarea_field($data['post_content']);
    $data['post_title'] = sanitize_text_field($data['post_title']);
  }

  if($data['post_type'] == 'note' AND $data['post_status'] != 'trash') {
    $data['post_status'] = 'private';
  }
  return $data;
}

add_filter('wp_insert_post_data', 'makeNotePrivate', 10, 2);