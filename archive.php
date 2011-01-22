<?php
	global $options;
		foreach ($options as $value) {
			if (get_settings( $value['id'] ) === FALSE) { 
				$$value['id'] = stripslashes( $value['std'] ); 
			} else { 
				$$value['id'] = stripslashes( get_settings( $value['id'] ) ); 
			} 
		}
?>
<?php get_header(); ?>

<?php /* Enables two or three columns */
if ($et_threecolumn_disable == "false") { ?> <?php include(TEMPLATEPATH."/sidebar.php");?><?php } ?>

   <div class="content <?php if ($et_threecolumn_disable == "false") { ?> <?php echo $et_columnorder; ?> <? } else { ?> content-two-column<?php echo $et_columnorder; ?> <?php } ?>">

     
 <div id="archive-heading">
  <div class="month">FIND A BOOK</div>
 </div> 

      
 
       
   
		<?php if (have_posts()) : ?>

      <div id="archive-navigation">
  
    
      <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
      <?php /* If this is a category archive */ if (is_category()) { ?>
      <h2 class="title"><?php single_cat_title(); ?></h2>
      <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
      <h2 class="title"><?php single_tag_title(); ?></h2>
      <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
      <h2 class="title">Archive for <?php the_time('F jS, Y'); ?></h2>
      <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
      <h2 class="title">Archive for <?php the_time('F, Y'); ?></h2>
      <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
      <h2 class="title">Archive for <?php the_time('Y'); ?></h2>
      <?php /* If this is an author archive */ } elseif (is_author()) { ?>
      <h2 class="title">Author Archive</h2>
      <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
      <h2 class="title">Blog Archives</h2>
      <?php } ?>
  
      <span class="return"><a href="/archive/">Return to Archive Index</a></span> 
      </div>
 	  
		<?php while (have_posts()) : the_post(); 
		$custom = get_post_custom();
		$cover_path = preg_replace('/\.(.{3})$/','-150x150.$1',$custom['book_cover_url'][0]);
		?>
		
		<div class="post">
				<img src='<?= $cover_path ?>' class='list-image' style="float: left;">
		    <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
		    <span class="author">by <?=$custom['book_author'][0]?></span>
		    </h2>
				<p class="archive-excerpt"><?php echo get_the_excerpt(); ?></p>
		    
		    <?php the_category(', ') ?><br>
				<?php if (function_exists('the_tags')) { the_tags('', ', '); } ?>

			</div>

		<?php endwhile; ?>

			<div class="navigation">
				<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } else { ?>
		
		        <div class="alignleft"><?php next_posts_link('&larr; Previous Entries') ?></div>
		        <div class="alignright"><?php previous_posts_link('Next Entries &rarr;') ?></div>
		        <?php } ?>
			</div>

	<?php else : ?>

		<div class="post">
			<h2 class="center">Not Found</h2>
			<p class="center">Sorry, but you are looking for something that isn't here.</p>
		</div>

	<?php endif; ?>

	</div>
	
<?php include(TEMPLATEPATH."/primary-sidebar.php");?>

<?php get_footer(); ?>
