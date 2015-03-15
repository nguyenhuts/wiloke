<?php

register_sidebar( array(
    'name'         => __( 'Arvios Sidebar', piCore::LANG ),
    'id'           => 'pi-sidebar',
    'description'  => __( 'Widgets in this area will be shown on the  side.', piCore::LANG ),
    'before_widget'=> '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title'  => '</h3>',
) );