<?php 

/**
 * Include Sections
 */

$aSections = isset(piThemeoptions::$piOptions['section_builder']) && !empty(piThemeoptions::$piOptions['section_builder']) ? piThemeoptions::$piOptions['section_builder'] : "";
$aSections = !empty($aSections) ? explode(",", $aSections) : piCore::$piaConfigs['sections'];

// get_template_part("sections/contact");


foreach ( $aSections as $name )
{	
	if ( in_array($name, piCore::$piaConfigs['sections']) )
	{
		$name = trim($name);
		get_template_part("sections/".$name);
	}else{
		pi_custom_section($name);
	}
}    


