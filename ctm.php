<?php

/**
 * Adds a view to the post being viewed
 *
 * Finds the current views of a post and adds one to it by updating
 * the postmeta. The meta key used is "awepop_views".
 *
 * @global object $post The post object
 * @return integer $new_views The number of views the post has
 *
*/

function ctm_add_view(){
    if(is_single()){
        global $post;

        $current_views = get_post_meta( $post->ID, "ctm_views", true );
        if(!isset($current_views) || empty($current_views) || !is_numeric($current_views)){
            $current_views = 0;
        }
        $new_views = $current_views + 1;
        update_post_meta( $post->ID, "ctm_views", $new_views );
        return $new_views;
    }
}

add_action( "wp_head", "ctm_add_view" );


// ===============================================================================================================


/**
 * Retrieve the number of views for a post
 *
 * Finds the current views for a post, returning 0 if there are none
 *
 * @global object $post The post object
 * @return integer $current_views The number of views the post has
 *
*/

function ctm_get_view_counts() {
    global $post;

    $current_views = get_post_meta( $post->ID, "ctm_views", true );
    if(!isset($current_views) OR empty($current_views) OR !is_numeric($current_views)) {
        $current_views = 0;
    }

    return $current_views;
}

add_action("wp_head", "ctm_get_view_counts");


// ===============================================================================================================


/**
 * Shows the number of views for a post
 *
 * Finds the current views of a post and displays it together with some optional text
 *
 * @global object $post The post object
 * @uses awepop_get_view_count()
 *
 * @param string $singular The singular term for the text
 * @param string $plural The plural term for the text
 * @param string $before Text to place before the counter
 *
 * @return string $views_text The views display
 *
*/

function ctm_show_views($singular = "view", $plural = "views", $before = "This post has: ") {
    global $post;

    $current_views = ctm_get_view_counts();

    $views_text = $before . $current_views . " ";

    if($current_views == 1){
        $views_text .= $singular;
    }
    else{
        $views_text .= $plural;
    }

    echo $views_text;
}

add_action( "wp_head", "ctm_show_views" );


// ===============================================================================================================


/**
 * Displays a list of posts ordered by popularity
 *
 * Shows a simple list of post titles ordered by their view count
 *
 * @param integer $post_count The number of posts to show
 *
*/

function ctm_popularity_list($post_count = 10) {
    $args = array(
        "posts_per_page" => $post_count,
        "post_type" => "post",
        "post_status" => "publish",
        "meta_key" => "ctm_views",
        "orderby" => "meta_value_num",
        "order" => "DESC",
    );

    $ctm_list = new WP_Query($args);

    if($ctm_list->have_posts()){
        echo "<ul>";
        while($ctm_list->have_posts()){
            $ctm_list->the_post();
            echo "<li><a href='" . the_permalink() . "'>" . the_title() . "</a></li>";
        }
        echo "</ul>";
    }
}


if(function_exists("ctm_popularity_list")){
    ctm_popularity_list();
}
