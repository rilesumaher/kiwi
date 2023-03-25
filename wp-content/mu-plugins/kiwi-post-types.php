<?php
function kiwi_post_types () {
    // Campus post type
    register_post_type('campus', array(
        'capability_type' => 'kiwi-campus',
        'map_meta_cap'  => true,
        'supports'      => array('title', 'editor', 'excerpt'),
        'rewrite'       => array('slug' => 'campuses'),
        'has_archive'   => true,
        'public'        => true,
        'labels'        => array(
            'name'      => 'Campuses',
            'add_new_item'  => 'Add New Campus',
            'edit_item' => 'Edit Campus',
            'all_items' => 'All Campuses',
            'singular_name' => 'Campus'
        ),
        'menu_icon'     => 'dashicons-location-alt',
    ));

    // Event post type
    register_post_type('event', array(
        'capability_type' => 'kiwi-event',
        'map_meta_cap'  => true,
        'supports'      => array('title', 'editor', 'excerpt'),
        'rewrite'       => array('slug' => 'events'),
        'has_archive'   => true,
        'public'        => true,
        'labels'        => array(
            'name'      => 'Events',
            'add_new_item'  => 'Add New Event',
            'edit_item' => 'Edit Event',
            'all_items' => 'All Events',
            'singular_name' => 'Event'
        ),
        'menu_icon'     => 'dashicons-calendar-alt',
    ));

    // Program post type
    register_post_type('program', array(
        'show_in_rest'  => true,
        'supports'      => array('title', 'excerpt'),
        'rewrite'       => array('slug' => 'programs'),
        'has_archive'   => true,
        'public'        => true,
        'labels'        => array(
            'name'      => 'Programs',
            'add_new_item'  => 'Add New Program',
            'edit_item' => 'Edit Program',
            'all_items' => 'All Programs',
            'singular_name' => 'Program'
        ),
        'menu_icon'     => 'dashicons-awards',
    ));

    // Professor post type
    register_post_type('professor', array(
        'show_in_rest'  => true,
        'supports'      => array('title', 'editor', 'excerpt', 'thumbnail'),
        'public'        => true,
        'labels'        => array(
            'name'      => 'Professors',
            'add_new_item'  => 'Add a New Professor',
            'edit_item' => 'Edit a Professor',
            'all_items' => 'All Professors',
            'singular_name' => 'Professor'
        ),
        'menu_icon'     => 'dashicons-welcome-learn-more',
    ));

    // Note post type
    register_post_type('note', array(
        // unique name
        'capability_type' => 'note',
        'map_meta_cap' => true,
        'show_in_rest'  => true,
        'supports'      => array('title', 'editor'),
        // This will also hide Notes in WP dash
        'public'        => false,
        // To show notes in WP dash add the following
        'show_ui'       => true,
        'labels'        => array(
            'name'      => 'Notes',
            'add_new_item'  => 'Add a New Note',
            'edit_item' => 'Edit a Note',
            'all_items' => 'All Notes',
            'singular_name' => 'Note'
        ),
        'menu_icon'     => 'dashicons-welcome-write-blog',
    ));

        // Like post type
        register_post_type('like', array(
            'supports'      => array('title'),
            // This will also hide Notes in WP dash
            'public'        => false,
            // To show notes in WP dash add the following
            'show_ui'       => true,
            'labels'        => array(
                'name'      => 'Likes',
                'add_new_item'  => 'Add a New Like',
                'edit_item' => 'Edit a Like',
                'all_items' => 'All Likes',
                'singular_name' => 'Like'
            ),
            'menu_icon'     => 'dashicons-heart',
        ));
}

add_action('init', 'kiwi_post_types');