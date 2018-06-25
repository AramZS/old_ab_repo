<?php get_header(); ?>

	<div id="content">
	
	<div style="width: 419px; background: #1F1D1D; border-top: 1px solid #000; border-bottom: 1px solid #000; margin: 0 0 20px 0;; padding: 8px 15px; font-size: 0.8em;">
		<img src="http://fightingfriends.com/images/dl_icon_dark.png" style="float: left; margin-right: 15px;" />
		<a href="http://fightingfriends.com/projects/sunburn/download.php">Download Sunburn 1.0.1 Now (201kb, zip)</a>
	</div>

	<?php if (have_posts()) : ?>
		
		<?php while (have_posts()) : the_post(); ?>
				
			<div class="post" id="post-<?php the_ID(); ?>">
			
				<div class="date">
					<div class="date_month"><?php the_time('M') ?></div>
					<div class="date_day"><?php the_time('d') ?></div>
				</div>
				
				<div class="title_box">
					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2> 
					<div class="comment_link"><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></div>
				</div>
				
				<div class="entry">
					<?php the_content('Read the rest &raquo;'); ?>
				</div>
		
				<p class="postmetadata">Category:<?php the_nice_category(', ', ' and '); ?></p>
			</div>
	
		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Previous Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Next Entries &raquo;') ?></div>
		</div>
		
	<?php else : ?>

		<h2 class="center">Not Found</h2>
		<p class="center">Sorry, but you are looking for something that isn't here.</p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>

	<?php endif; ?>

	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
