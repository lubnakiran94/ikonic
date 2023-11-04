<?php
/*
Template Name: Home Page
*/ 
?>
<?php
get_header();?>
<section class="hero-section">
    <div class="container">
        <h1><?php the_field('heading'); ?></h1>
        <div class="section-content">
            <?php echo do_shortcode(get_field('shortcode_content')); ?>
        </div>
    </div>
</section>
<section class="faq-section">
    <div class="container">
        <h1>FAQ's</h1>
      <?php echo do_shortcode('[faqs]'); ?>
    </div>
</section>


<?php
get_footer();