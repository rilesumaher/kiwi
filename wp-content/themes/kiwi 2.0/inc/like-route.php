<?php
function kiwiLikeRoutes() {
    register_rest_route('kiwi/v1', 'like', array(
        // CRUD is 'methods' bellow
        'methods' => 'POST',
        'callback' => 'createLike'
    ));

    register_rest_route('kiwi/v1', 'like', array(
        // CRUD is 'methods' bellow
        'methods' => 'DELETE',
        'callback' => 'deleteLike'
    ));
}

add_action('rest_api_init', 'kiwiLikeRoutes');

function createLike($data) {
    if(is_user_logged_in()) {
        $professor = sanitize_text_field($data['professorId']);

        $existQuery = new WP_Query(array(
            'author' => get_current_user_id(),
            'post_type' => 'like',
            'meta_query' => array(
              array(
                'key' => 'liked_professor_id',
                'compare' => '=',
                'value' => $professor
              )
            )
          ));

        if($existQuery->found_posts == 0 AND get_post_type($professor) == 'professor') {
            return wp_insert_post(array(
                'post_type' => 'like',
                'post_status' => 'publish',
                'meta_input' => array(
                    'liked_professor_id' => $professor
                )
            ));
        } else {
            die("Invalid professor ID or you already liked this professor.");
        }
        
    } else {
        die("Die");
    }
    
}

function deleteLike($data) {
    $likeId = sanitize_text_field($data['like']);
    if(get_current_user_id() == get_post_field('post_author', $likeId) AND get_post_type($likeId) == 'like') {
        wp_delete_post($likeId, true);
        return 'Congrats, like deleted.';
    } else {
        die("You don't have permission to delete this post.");
    }
}