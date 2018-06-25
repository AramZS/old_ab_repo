<!-- ========================================================
Header
======================================================== -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php bloginfo("title");?></title>
<!-- CSS Styles are in Style.css -->
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<!-- RSS LINKING -->
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<!-- END of RSS LINKING -->
<?php wp_head(); ?>
</head>

<body>
<div id="centerWrapper">
	<div id="header">
     <div id="rssButton">


        
            <a href="<?php bloginfo("rss2_url"); ?>"><span id="rssIcon">
            </span> <!-- rssIcon --></a>
        
            <div id="rssText">
            
                <p class="rssSub"><a href="<?php bloginfo("rss2_url");?>">Subscribe to RSS Feed</a></p>
                <p class="rssSub"><a href="<?php bloginfo('comments_rss2_url'); ?>">Subscribe to Comments Feed</a></p>
                <p class="rssSub"><a href="<?php bloginfo("atom_url");?>">Subscribe to Atom Feed</a></p>
            
            </div> <!-- rssText -->
        
        </div> <!-- rssButton -->
   		<h1 id="hTitle"><a href="<?php bloginfo("url");?>"> <?php bloginfo("title");?> </a></h1><div id="tagline"><?php bloginfo('description'); ?></a>
		


    </div> <!-- header -->
    <div id="menubar">
    	<?php wp_page_menu();?>
    </div>
    <div id="postAndSidebar">
    
    	<div id="postsWrapper">
        
        	<div id="postContent">