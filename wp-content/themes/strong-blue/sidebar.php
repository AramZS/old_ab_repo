<!-- ========================================================
Sidebar
======================================================== -->

    	<div id="sidebar">
        
        	<div id="innerSidebar">
        	<div id="sideFix1"></div>
            <div style="text-align:center">
			<?php get_search_form(); ?>
            </div>
        	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar') ) : ?>
            
            
            <?php endif;?>
            <div id="sideFix2"></div>
            </div><!-- innerSidebar -->

        </div><!-- sidebar -->
