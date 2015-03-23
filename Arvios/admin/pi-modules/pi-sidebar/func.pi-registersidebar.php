<?php

register_sidebar( array(
    'name'         => __( 'Arvios - Blog Sidebar', 'wiloke' ),
    'id'           => 'pi-sidebar',
    'description'  => __( 'Widgets in this area will be shown on the  side.', 'wiloke' ),
    'before_widget'=> '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title'  => '</h3>',
) );

register_sidebar( array(
    'name'         => __( 'Arvios - Woocommerce Sidebar', 'wiloke' ),
    'id'           => 'pi-woocommerce',
    'description'  => __( 'Widgets in this area will be shown on the  side.', 'wiloke' ),
    'before_widget'=> '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title'  => '</h3>',
) );