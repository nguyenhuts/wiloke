<?php 
  if ( apply_filters('pi_is_section_enable', 'header') ) :
?>
<?php 
  do_action("pi_arvios_before_header");
  pi_header_bg();
  do_action("pi_arvios_after_header");
?>
<?php 
endif;
?>