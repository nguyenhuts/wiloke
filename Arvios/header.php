<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<title><?php wp_title('|', true, 'right'); ?></title>
	<link href="//www.google-analytics.com" rel="dns-prefetch">
 	<?php
    if ( isset(piThemeOptions::$piOptions['favicon_touch']['enable']) && !empty(piThemeOptions::$piOptions['favicon_touch']['enable']) ) : 
        if ( isset(piThemeOptions::$piOptions['favicon_touch']['favicon']) && !empty(piThemeOptions::$piOptions['favicon_touch']['favicon']) ) :
    ?>
        <link href="<?php echo esc_url(piThemeOptions::$piOptions['favicon_touch']['favicon']) ?>" rel="shortcut icon">
    <?php 
        endif;
        if ( isset(piThemeOptions::$piOptions['favicon_touch']['touch']) && !empty(piThemeOptions::$piOptions['favicon_touch']['touch']) ) :
    ?>
        <link href="<?php echo esc_url(piThemeOptions::$piOptions['favicon_touch']['touch']); ?>" rel="apple-touch-icon-precomposed">
    <?php 
        endif;
    endif;
    ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta name="format-detection" content="telephone=no">
	<?php wp_head(); ?>
</head>
<body id="page-top" <?php body_class(); ?><?php if ( pi_is_static_page() && is_page_template('homepage.php') ) : ?> data-spy="scroll"<?php endif; ?>>
	
	<div id="top"></div>

<!-- PRELOADER --> 
<?php if ( isset(piThemeOptions::$piOptions['preload']['enable']) && !empty(piThemeOptions::$piOptions['preload']['enable']) ) : ?>
<div class="preloader">
  <span class="loading zoom">
    <span>L</span><span>o</span><span>a</span><span>d</span><span>i</span><span>n</span><span>g</span>
  </span>
</div>
<?php endif; ?>
<!-- END / PRELOADER -->

<div id="page-wrap" <?php if( pi_is_static_page() ) : ?> class="onepage" <?php endif; ?>>

<?php 
	get_template_part("sections/header");
?>