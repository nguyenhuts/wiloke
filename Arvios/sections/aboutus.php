<?php 
if ( apply_filters('pi_is_section_enable', 'aboutus') ) :
?> 
<?php  
do_action("pi_arvios_before_about"); 
?>

<section id="aboutus" class="story<?php pi_add_hidden('aboutus');?>">
  <?php pi_get_background('aboutus'); ?>
  <div class="wellcome st-heading text-center">
      <?php apply_filters( 'pi_the_heading', 'aboutus', 'welcome' ); ?>
      <?php apply_filters( 'pi_the_description', 'aboutus' ); ?>
  </div>
  <?php 
    $getID = apply_filters('pi_get_data', 'aboutus');
    if ( $getID ) : 
      $piaData = get_post_meta($getID, "_pi_aboutus", true);
  ?>
  <div class="story-body">
    <?php 
      if ( !empty($piaData) && is_array($piaData) ) : 
      $i = 2;
      foreach ( $piaData as $key => $aData ) : 
    ?>
    <div class="tb">
    <?php 

      if ( $i%2 == 0 ) :
        pi_aboutus_photo($aData);
        pi_aboutus_intro($aData);
      else:
        pi_aboutus_intro($aData);
        pi_aboutus_photo($aData);
      endif;
    ?>
    </div>
    <?php $i++;endforeach;endif; ?>
  </div>
      <?php 
  endif; 
      ?>
</section>
  
<?php 
  do_action("pi_arvios_after_about");
?>
<?php 
endif;
?>