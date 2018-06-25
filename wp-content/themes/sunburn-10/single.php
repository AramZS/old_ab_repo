<?php get_header(); ?>

	<div id="content" class="widecolumn">
				
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
		<div class="post" id="post-<?php the_ID(); ?>">
			<h2><?php the_title(); ?></h2>	

			<div class="entrytext">
Posted by <?php the_author_posts_link(); ?> on <?php the_date('Y-m-j'); ?>

				<?php the_content('<p class="serif">Read the rest &raquo;</p>'); ?>
	
				<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>

	<p class="postmetadata">Category: <?php the_nice_category(', ', ' and '); ?> <?php  the_tags(); ?></p>
			</div>
		</div>
		
	<?php comments_template(); ?>
	
	<?php endwhile; else: ?>
	
		<p>Sorry, no posts matched your criteria.</p>
	
<?php endif; ?>
	
	</div>
	
	<div id="sidebar" style="color: #ccc; font-size: 0.8em;">
	
		<p><a href="<?php bloginfo('url'); ?>">Home</a></p>
	
		<p class="postmeta_single">
<!---	
				Posted: <?php the_time('F jS, Y') ?><br />
				Category: <?php the_nice_category(' , ', ' and ') ?><br />
                                Tags: <?php the_tags(); ?><br />
				Comments Feed: <?php comments_rss_link('RSS 2.0'); ?> <br />
			
				<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
					// Both Comments and Pings are open ?>
					You can <a href="#respond">leave a response</a>, or <a href="<?php trackback_url(true); ?>" rel="trackback">trackback</a> from your own site.
				
				<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
					// Only Pings are Open ?>
					Responses are currently closed, but you can <a href="<?php trackback_url(true); ?> " rel="trackback">trackback</a> from your own site.
				
				<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
					// Comments are open, Pings are not ?>
					You can skip to the end and leave a response. Pinging is currently not allowed.
	
				<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
					// Neither Comments, nor Pings are open ?>
					Both comments and pings are currently closed.			
				
				<?php } edit_post_link('Edit this entry.','',''); ?>
--->
		</p>
	
	
		<div class="navigation">
			<div class="alignright"><?php next_post_link('%link &raquo;') ?></div>
			<div class="alignleft"><?php previous_post_link('&laquo; %link') ?></div>
		</div>
	
	</div>

<?php get_footer(); ?>
