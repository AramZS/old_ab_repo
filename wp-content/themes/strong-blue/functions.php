<?php

	if(function_exists('register_sidebar')) {
			register_sidebar(array(
							 'name'=>'sidebar',
							  'before_widget'=>'',
							  'after_widget'=>'</div><!-- widgetCon -->',
							  'before_title'=>'<div class="widgetTitle"><h2>',
							  'after_title'=>'</h2></div><div class="widgetCon">'
							 ));
			register_sidebar(array(
							 'name'=>'footer',
							  'before_widget'=>'<div class="footerWidget">',
							  'after_widget'=>'</div><!-- widgetCon --></div><!-- footerWidget -->',
							  'before_title'=>'<div class="widgetTitle"><h2>',
							  'after_title'=>'</h2></div><div class="widgetCon">'
							 ));
	}

	


?>