<?php get_header();?>
<!-- ========================================================
Main
======================================================== -->
            <div class="fixer1"></div>
            	<?php if (have_posts()) : while (have_posts()) : the_post();?>
                
                <div class="postTitle">
                	<div class="titleInnerDiv">
                	 <h2><a href="<?php the_permalink() ?>"><?php the_title();?></a></h2>
                     <span class="postSubtitle"> by <?php the_author()?> <?php  the_tags(); ?></span>
                     <div class="dateSubtitle"> <?php the_time("d m Y")?> </div>
                    </div><!-- titleInnerDiv -->

                </div><!-- postTitle -->
                
                <div class="postMainContent">
                		<?php the_content("<span style='display:none;'>Read More</span>");?>
                </div><!-- postMainContent -->
                
              <div class="fixer2"></div>
                
                 <div class="commentBuble">
                    <span class="commentGraph"><?php comments_number('0','1','%');?></span>
                    <span class="commentTxt">  comments</span>
                 </div><!-- ccommentBuble -->
                 
                   <?php endwhile;?>
					 <?php else : ?>
         
                        <div class="postTitle">
                            <h2>Not Found</h2>
                        </div><!-- postTitle -->   
                     
                        <div class="postMainContent">
                            <p> Nothing to see here</p> 
                         </div><!-- postMainContent -->
                        
                     </div><!-- .post -->
                     <?php endif;?>
                   <div class="fixer2"></div>
                   <div id="commentArea1">

<?php comments_template();?></div>
            </div><!-- postContent -->
       
        </div><!-- postsWrapper -->

			<?php get_sidebar();?>
         <div class="footerFix"></div>
    </div><!-- postAndSidebar -->

<?php get_footer();?>