<?php
/*
Template Name: Archives
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
     <?php $latest = get_posts( array('numberofposts' => 5) ); 
       echo "<div style='display: none'>";
       foreach($latest as $late) {
          $custom = get_post_custom($late->ID);
          $path = preg_replace('/\.(.{3})$/','-150x150.$1',$custom['book_cover_url'][0]);
          $images[] = $path;
       }
       echo "</div>";
       ?>  
       
    <table id="archive-main">
      <tr>
        <td>
          <a href="/archive/age-group/"><img src="<?=$images[0]?>" /><br>
            by Age Group</a></td>
        <td>
            <a href="/archive/subject/"> <img src="<?=$images[1]?>" /><br>
             by Subject</a></td>
        <td>
           <a href="/archive/type/"><img src="<?=$images[2]?>" /><br>
           by Type of Book</a></td>
      </tr>
      <tr>
        <td>
             <a href="/archive/author/"><img src="<?=$images[3]?>" /><br>
             by Author/Illustrator</a></td>
        <td>
           <a href="/archive/date/"><img src="<?=$images[4]?>" /><br>
           by Date Featured</a></td>
      </tr>
   </table>


</div>

<?php include(TEMPLATEPATH."/primary-sidebar.php");?>

<?php get_footer(); ?>
