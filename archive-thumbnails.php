<?php
/*
Template Name: Archives with Thumbnails
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
           $groups = $custom['filter_tag']; ?>
        <?php endwhile; endif; ?>
       
    <div id="archive-navigation">
  
      <span class="title"> <?=strtoupper($title)?> </span>
    <span class="return"><a href="/archive/">Return to Archive Index</a></span>

    </div>
       
    <table id="archive-main">
       <?php
       $row = 0;
       foreach($groups as $key => $group){
         $latest = get_posts( array('numberofposts' => 1, 'tag' => str_replace(' ','-',$group) ) );
         $group_slug = str_replace(' ','-',$group);
         if (sizeof($latest) > 0 ) {
         
           if($row % 3 == 0) echo "<tr>";
           
           
           echo "<td>";
           
                    $custom = get_post_custom($latest[0]->ID);
           $path = preg_replace('/\.(.{3})$/','-150x150.$1',$custom['book_cover_url'][0]);
           echo "<a href='/tag/$group_slug'><img src='$path' ><br>";
           echo $group;
           
           echo "</a></td>";
           
           
           if($row % 3 == 2) echo "</tr>";
           $row++;
         }
       }
       ?>

   </table>

</div>

<?php include(TEMPLATEPATH."/primary-sidebar.php");?>

<?php get_footer(); ?>
