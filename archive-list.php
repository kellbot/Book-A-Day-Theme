<?php
/*
Template Name: List view for Archives
*/
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

              <?php if (have_posts()) : while (have_posts()) : the_post();?>
          <?php $custom = get_post_custom(); 
          $title = get_the_title();
?>
        <?php endwhile; endif; ?>
    <div id="archive-navigation">
  
      <span class="title"> <?=strtoupper($title)?> </span>
    <span class="return"><a href="/archive/">Return to Archive Index</a></span>

    </div>
  <ul id="archive_date"> 	    
 <?php wp_get_archives('type=monthly&limit=12'); ?>
  </ul>
</div>

<?php include(TEMPLATEPATH."/primary-sidebar.php");?>

<?php get_footer(); ?>
