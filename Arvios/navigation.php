<?php
if ( has_nav_menu( piCore::$piaConfigs['menus']['menu_id'] ) ) : 
    $args = array(
        'theme_location'  => piCore::$piaConfigs['menus']['menu_id'],
        'menu'            => '',
        'container'       => '',
        'container_class' => '',
        'container_id'    => '',
        'menu_class'      => 'nav text-uppercase',
        'menu_id'         => 'pi-main-menu',
        'echo'            => true,
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        'walker'          => ''
    );

    wp_nav_menu($args);
endif;   