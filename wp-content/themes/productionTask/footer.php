<footer class="custom-footer">
    <div class="col-12 col-xl-8 col-lg-8">
            <div class="row"> 
                <?php $site_logo = get_field('site_logo', 'option'); ?>
            <div class="col-4 col-sm-2 col-lg-2">
                <img class="logo" src="<?php echo esc_url($site_logo);?>" alt="Your Logo" /></a>
              </div>  
            <div class="col-6 col-sm-4 col-lg-3">
                
                <?php
                    wp_nav_menu(
                        array(
                            'container' => false,
                            'theme_location' => 'footer-menu',
                            'menu_class' => 'footer-menu'
                        )
                    ); 
                ?>    
            </div>   
               </div></div>
               <div class="col-12 col-xl-8 col-lg-8">
                <div class="row"> 
                    <div class="col-6 col-sm-4 col-lg-3">
                        <?php 
                        $site_address = get_field('address', 'option');
                        $contact_number = get_field('phone_number', 'option');?>
                        <p>Address: <?php echo esc_html($site_address); ?></p>
                        <p>Contact: <?php echo esc_html($contact_number); ?></p>
               </div>
</footer>