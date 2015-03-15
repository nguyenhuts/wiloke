<?php if ( !is_404 () ) : ?>
<!-- HEADER -->
<header id="header" class="header">

    <!-- HOME MEDIA -->
    <?php 
    if ( pi_is_static_page() && is_page_template('homepage.php')   ) :
        get_template_part("sections/land");
    endif;
    ?>
     
    <!-- NAVIGATION -->
    <nav class="pi-navigation <?php pi_nav_menu(); ?> navigation nav-top" data-menu-type="<?php echo isset(piThemeOptions::$piOptions['menu_config']) ? (int)piThemeOptions::$piOptions['menu_config'] : 1300;  ?>">
        <div class="container">
            <!-- LOGO NAV -->

            <?php pi_display_logo(); ?>
            <!-- END / LOGO NAV -->
             
            <?php if ( has_nav_menu( piCore::$piaConfigs['menus']['menu_id'] ) ) :  ?>
            
                <?php  get_template_part("navigation"); ?>
                

                <!-- TOGGLE MENU MOBILE -->
                <a href="#" class="open-menu">
                    <span class="item"></span>
                </a>
                <!-- END / TOGGLE MENU MOBILE -->

            <?php endif; ?>
            
        </div>
    </nav>
    <!-- END / NAVIGATION -->

</header>

<?php endif; ?>
<!-- END / HEADER -->