<?php 
if ( apply_filters('pi_is_section_enable', 'twitter') ) :
?>
<?php 
  do_action("pi_arvios_before_twitter");
?>
<!-- TWITTER -->
<section id="twitter" class="twitter<?php pi_add_hidden('twitter');?>">
    <?php pi_get_background('twitter'); ?>
    <div class="container">
        <div class="st-heading text-center">
            <span class="h3"><i class="fa fa-twitter"></i></span>
            <?php apply_filters( 'pi_the_heading', 'twitter' ); ?>
            <?php apply_filters( 'pi_the_description', 'twitter' ); ?>  
        </div>
        <div class="st-body">
            <div class="row pi-fill-twitter">
            </div>
        </div>
    </div>
</section>
<?php
endif;
?>