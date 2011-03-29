<?php
/*
Template Name: Archives for a Single Author
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
          <?php
           $author = is_null($_GET['a']) ? $_GET['b'] : $_GET['a']; ?>
        <?php endwhile; endif; ?>
       
    <div id="archive-navigation">
  
      <span class="title"> <?=strtoupper($author)?> </span>
    <span class="return"><a href="/archive/">Return to Archive Index</a></span>

    </div>
       
    <table id="archive-main">
       <?php
       $row = 0;
       $results = get_posts( array('orderby' => 'rand', 'meta_value' => $author ) );
       $group_slug = str_replace(' ','-',$group);
       foreach ($results as $result) : setup_postdata($result);
         $custom = get_post_custom($result->ID);
         $cover_path = preg_replace('/\.(.{3})$/','-150x150.$1',$custom['book_cover_url'][0]);
         ?>
         <div class="post archive-listing">
     				<img src='<?= $cover_path ?>' class='list-image' style="float: left;">
       		  <div style="margin-left: 160px;">
       		    <h2><a href="<?= get_permalink($result->ID) ?>" rel="bookmark" title="Permanent Link to <?=$result->post_title?>"><?= $result->post_title; ?></a>
       		    <?php if($custom['book_author'][0]) { 
					?><span class="author">by <?=$custom['book_author'][0]?></span>
						<?php if($custom['book_illustrator'][0]) { ?><br><span class="author">Illustrated by <?=$custom['book_illustrator'][0]?></span><?php } ?>
				<? } ?>
				</h2>
       		    <?php if (function_exists('the_tags')) { the_tags('', ', '); } ?>
       				<p class="archive-excerpt"><?php the_excerpt(); ?></p>

       		    <?php the_category(', ') ?><br>
               Featured on <?= date('F t, Y',strtotime($result->post_date)); ?>
             </div>
     			</div>
   <?php endforeach;
   wp_reset_query();
       ?>

   </table>

</div>

<?php include(TEMPLATEPATH."/primary-sidebar.php");?>

<?php get_footer(); ?>
