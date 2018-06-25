<?php

function thesis_html_framework() {
	global $thesis_design;
	
	get_header();
	
	if ($thesis_design['layout']['framework'] == 'page')
		thesis_framework_page();
	elseif ($thesis_design['layout']['framework'] == 'full-width')
		thesis_framework_full_width();
	else
		thesis_framework_page();
		
	get_footer();
}

function thesis_framework_page() {
	echo '<div id="container">' . "\n";
	echo '<div id="page">' . "\n";
	
	thesis_header_area();
	thesis_content();
	thesis_footer_area();
	
	echo '</div>' . "\n";
	echo '</div>' . "\n";
}

function thesis_framework_full_width() {
	thesis_wrap_header();
	thesis_wrap_content();
	thesis_wrap_footer();
}

function thesis_wrap_header() {
	echo '<div id="header_area" class="full_width">' . "\n";
	echo '<div class="page">' . "\n";
	
	thesis_header_area();
	
	echo '</div>' . "\n";
	echo '</div>' . "\n";
}

function thesis_wrap_content() {
	thesis_hook_before_content_area();
	
	echo '<div id="content_area" class="full_width">' . "\n";
	echo '<div class="page">' . "\n";
	
	thesis_content();
	
	echo '</div>' . "\n";
	echo '</div>' . "\n";
	
	thesis_hook_after_content_area();
}

function thesis_wrap_footer() {
	echo '<div id="footer_area" class="full_width">' . "\n";
	echo '<div class="page">' . "\n";
	
	thesis_footer_area();
	
	echo '</div>' . "\n";
	echo '</div>' . "\n";
}