<?php
/*
Plugin Name: Faq-plugin
Description: Plugin to generate FAQ's.
Version: 1.0
Author: Lubna
Text Domain: faq-custom-generator
*/

function register_faq_post_type() {
    register_post_type('faq', array(
        'labels' => array(
            'name' => 'FAQs',
            'singular_name' => 'FAQ',
        ),
        'public' => true,
        'supports' => array('title', 'editor'),
    ));
}
add_action('init', 'register_faq_post_type');

function add_faq_custom_meta_boxes() {
    add_meta_box('faq_question', 'Question', 'render_faq_question_field', 'faq', 'normal', 'default');
    add_meta_box('faq_answer', 'Answer', 'render_faq_answer_field', 'faq', 'normal', 'default');
}
add_action('add_meta_boxes', 'add_faq_custom_meta_boxes');

function render_faq_question_field($post) {
    $question = get_post_meta($post->ID, 'faq_question', true);
    echo '<input type="text" name="faq_question" value="' . esc_attr($question) . '" style="width: 100%;" />';
}

function render_faq_answer_field($post) {
    $answer = get_post_meta($post->ID, 'faq_answer', true);
    echo '<textarea name="faq_answer" style="width: 100%;" rows="5">' . esc_textarea($answer) . '</textarea>';
}
function save_faq_custom_meta_data($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if ($post_id && isset($_POST['faq_question'])) {
        update_post_meta($post_id, 'faq_question', sanitize_text_field($_POST['faq_question']));
    }
    if ($post_id && isset($_POST['faq_answer'])) {
        update_post_meta($post_id, 'faq_answer', sanitize_textarea_field($_POST['faq_answer']));
    }
}
add_action('save_post', 'save_faq_custom_meta_data');

function render_faqs_shortcode() {
    $args = array(
        'post_type' => 'faq',  
        'posts_per_page' => -1,
    );

    $faqs = new WP_Query($args);

    if ($faqs->have_posts()) {
        $output = '<div class="faq-list">';

        while ($faqs->have_posts()) {
            $faqs->the_post();
            $question = get_post_meta(get_the_ID(), 'faq_question', true);
            $answer = get_post_meta(get_the_ID(), 'faq_answer', true);

            if (!empty($question) && !empty($answer)) {
                $output .= '<div class="faq">';
                $output .= '<h2>' . esc_html($question) . '</h2>';
                $output .= '<div class="answer">' . esc_html($answer) . '</div>';
                $output .= '</div>';
            }
        }

        $output .= '</div>';
    } else {
        $output = 'No FAQs found.';
    }

    wp_reset_postdata();

    return $output;
}
add_shortcode('faqs', 'render_faqs_shortcode');
