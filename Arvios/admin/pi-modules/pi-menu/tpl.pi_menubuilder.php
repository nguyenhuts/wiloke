<?php 

$_nav_menu_placeholder = -1000;

$homeUrl = "";


$aSetting = array('page-top'=>'Home', 'aboutus'=>'About', 'services'=>'Services', 'funfacts'=>'Fun Facts', 'idea'=>'Idea', 'team'=>'Team',  'skills'=>'Skills',  'portfolio'=>'Our Work', 'clients'=>'Our Clients', 'testimonials'=>'Testimonials', 'pricing'=>'Pricing', 'twitter'=>'Twitter', 'blog-section'=>'Latest News', 'contact'=>'Contact Us');


?>

<div id="piaddmenu" class="piaddmenu">
    <div id="tabs-panel-wishlist-login" class="tabs-panel tabs-panel-active">
        <ul class="categorychecklist form-no-clear" class="categorychecklist form-no-clear">    
            <?php foreach ($aSetting as $k => $v) : ?>
            <li>
                <label class="menu-item-title"> 
                    <input   class="menu-item-checkbox" type="checkbox" value="<?php echo $_nav_menu_placeholder ?>" name="menu-item[<?php echo $_nav_menu_placeholder ?>][menu-item-object-id]">
                    <?php  echo $v ?>
                </label>
                <input  class="menu-item-object" type="hidden" value="custom" name="menu-item[<?php echo $_nav_menu_placeholder ?>][menu-item-object]">
                <input  name="menu-item[<?php echo $_nav_menu_placeholder ?>][menu-item-url]" type="hidden" class="code pirates-te-menu menu-item-textbox" value="<?php echo '#' . $k; ?>" />
                <input  name="menu-item[<?php echo $_nav_menu_placeholder ?>][menu-item-title]" type="hidden" class="pirates-te-menu regular-text menu-item-textbox input-with-default-title" title="<?php echo $v; ?>"  value="<?php echo $v; ?>"/>
                <input class="menu-item-type" type="hidden" value="custom" name="menu-item[<?php echo $_nav_menu_placeholder ?>][menu-item-type]">
                <input class="menu-item-section-name" type="hidden" value="" name="menu-item[<?php echo $_nav_menu_placeholder - 1; ?>][menu-item-section-name]" value="<?php echo $k ?>">
            </li>
            <?php
                --$_nav_menu_placeholder;
               endforeach;
            ?>
        </ul>
    </div>
    <p class="button-controls">
        <span class="add-to-menu">
        <input type="submit" class="button-secondary submit-add-to-menu right" value="Add to Menu" name="add-post-type-menu-item" id="submit-piaddmenu">
        <span class="spinner"></span>
        </span>
    </p>
</div>
