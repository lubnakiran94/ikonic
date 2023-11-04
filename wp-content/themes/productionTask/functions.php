<?php
function add_widget_support() {
               register_sidebar( array(
                               'name'          => 'Sidebar',
                               'id'            => 'sidebar',
                               'before_widget' => '<div>',
                               'after_widget'  => '</div>',
                               'before_title'  => '<h2>',
                               'after_title'   => '</h2>',
               ) );
}

add_action( 'widgets_init', 'add_widget_support' );

// Register a new navigation menu
function add_Main_Nav() {
  register_nav_menu('header-menu',__( 'Header Menu' ));
}

add_action( 'init', 'add_Main_Nav' );

// enque styles
function my_custom_style() {
    wp_enqueue_style( 'custom_style',  get_template_directory_uri() . '/assets/custom-style.css');  
                       
}
add_action( 'wp_enqueue_scripts', 'my_custom_style' );

//Adding Menu Locations
function theme_menus()
{
    register_nav_menus(
        array(
            'header-menu' => __('Header Menu'),
        )
    );

    
    register_nav_menus(
        array(
            'footer-menu' => __('Footer Menu'),
        )
    );
    
}
add_action('init', 'theme_menus');

// API Call
function fetch_countries_and_flags() {
   
    $api_url = 'https://restcountries.com/v3.1/all?fields=name,flags';

    $response = wp_remote_get($api_url);

   
    if (is_wp_error($response)) {
        return 'Failed to retrieve data.';
    }

    $data = json_decode(wp_remote_retrieve_body($response));

    
    $output = '<ul class="country-list">';
    foreach ($data as $country) {
        $country_name = $country->name->common;
        $country_flag = $country->flags->svg;

        $output .= '<li>';
        $output .= '<img src="' . esc_url($country_flag) . '" alt="' . esc_attr($country_name) . '" width="32" height="32">';
        $output .= esc_html($country_name);
        $output .= '</li>';
    }
    $output .= '</ul>';
    return $output;
}
function countries_and_flags_shortcode() {
    return fetch_countries_and_flags();
}
add_shortcode('country_flags', 'countries_and_flags_shortcode');

