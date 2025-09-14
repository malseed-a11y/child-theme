<?php

function mosaab_child_styles()
{
    $version = wp_get_theme()->get('Version');


    wp_enqueue_style(
        'child-style',
        get_stylesheet_directory_uri() . './style.css',
        array('mosaab-style'),
        $version,
        'all'
    );
}

add_action('wp_enqueue_scripts', 'mosaab_child_styles');



//----------- Add a filter to the title of the post

function mosaab_child_title_filter($title)
{
    return $title . '&reg;';
}
add_filter('the_title-filter', 'mosaab_child_title_filter');



//-----------Add ✨ to the comment text

function mosaab_child_comment_filter($comment_text)
{
    return $comment_text . ' ✨';
}
add_filter('comment_text', 'mosaab_child_comment_filter');

//-----------Add a scoial links

function mosaab_child_social_links($content)
{
    $content .= '<div class="social-list">
    <hr>
    <h3>Follow us on</h3>
    <a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a>
    <a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a>
    <a href="https://www.github.com/"><i class="fab fa-github"></i></a>
    <a href="https://www.linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
    <hr>
    </div>';
    return $content;
}
add_action('the_content', 'mosaab_child_social_links');





function filter_content_banner_color()
{
    return '#71a125ff';
}
add_filter('content_banner_color', 'filter_content_banner_color');



function count_user_visits_about_us_page($content, $color)
{
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        $user_visits_count = !empty(get_user_meta($user_id, 'user_visits_count', true)) ? absint(intval(get_user_meta($user_id, 'user_visits_count', true))) : 0;
        $user_visits_count = $user_visits_count + 1;
        update_user_meta($user_id, 'user_visits_count', $user_visits_count);
    }
    $user_visits_count_div = '<div class="user-visits-count" style="background-color:' . esc_attr($color) . '; color: #fff; padding: 10px; margin-top: 20px; text-align: center;">';
    $user_visits_count_div .= '<p>You have visited this page ' . $user_visits_count . ' times.</p>';
    $user_visits_count_div .= '</div>';
    echo $user_visits_count_div;
}
add_action('banner_added', 'count_user_visits_about_us_page', 3, 2);


function display_user_name($content, $banner_color)
{
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();

        echo '<p class="welcome-message" style="background-color:' . esc_attr($banner_color) . '; color: #fff; padding: 10px; margin-top: 20px; text-align: center;">Welcome, ' . esc_html($current_user->display_name) . '!</p>';
    }
}
add_action('banner_added', 'display_user_name', 10, 2);



function get_website_users_count()
{
    $user_count = count_users();
    return $user_count['total_users'];
}
add_filter('count_users', 'get_website_users_count', 11);

function fixed_users_count()
{
    return 150; // Fixed number of users
}
add_filter('count_users', 'fixed_users_count', 10);
