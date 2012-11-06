<?php
/*
Template Name: Calendar For Date Archives
*/
		global $options;

		foreach ($options as $value) {
			if (get_settings( $value['id'] ) === FALSE) { 
				$$value['id'] = stripslashes( $value['std'] ); 
			} else { 
				$$value['id'] = stripslashes( get_settings( $value['id'] ) ); 
			} 
		}
		
		$archive_month = $wp_query->query_vars['archive_month'];
?>

<?php get_header(); ?>

<?php /* Enables two or three columns */
if ($et_threecolumn_disable == "false") { ?> <?php include(TEMPLATEPATH."/sidebar.php");?><?php } ?>

   <div class="content <?php if ($et_threecolumn_disable == "false") { ?> <?php echo $et_columnorder; ?> <? } else { ?> content-two-column<?php echo $et_columnorder; ?> <?php } ?>">

   
 <div id="archive-heading">
  <div class="month">FIND A BOOK</div>
 </div> 



		<div id="archive-navigation">
  
      <span class="title"> <?=strtoupper($title)?> </span>
    <span class="return"><a href="/archive/">Return to Archive Index</a></span>

    </div>
<?php if ($archive_month){ ?>
	<ul id="archive_date"> 	
<?php
       
        //loop through each day of the month. This has the potential to get slow if there's a lot of traffic.
		for ($d = 1; $d <= 31; $d++){
		    //Query for that day across any month
			query_posts( array ('monthnum' => $archive_month, 'day' => $d));
			if($wp_query->found_posts > 0) echo "<li><div class='day-number'>$d</div>";
			while ( have_posts() ) : the_post();
	

				$custom = get_post_custom();
         		$cover_path = preg_replace('/\.(.{3})$/','-150x150.$1',$custom['book_cover_url'][0]);

				?>
				<div class="post">
         				<img src='<?= $cover_path ?>' class='list-image' style="float: left;">
         		    <div style="margin-left: 155px">
         		      <h2><a href="<?php the_permalink() ?>?y=<?=date('Y')?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
         		        <span class="author">by <?=$custom['book_author'][0]?></span>
         		      </h2>
         				  <p class="archive-excerpt"><?php echo get_the_excerpt(); ?></p>

         		      <?php the_category(', ') ?><br>
         				  <?php if (function_exists('the_tags')) { the_tags('', ', '); } ?>
                  <br>
                  Featured on <?php the_date(); ?>
                </div>
         			</div>
					<?php
			endwhile;
			if($wp_query->found_posts > 0) echo "</li>";
			wp_reset_query();
		}
		
    } else {  ?>

	<table id="archive-main">	
<?  

    
        //generate a preview for each month  
		for ( $i = 1; $i <= 12; $i++ ) {
		        //if this is the beginning of a row, open a row tag
		        if($i % 3 == 1) echo "<tr>";
				echo "<td><a href='/archive/date/?archive_month=$i'>";
				
				
				$text = $wp_locale->get_month($i);
				
				//get a random cover from that month
				$cover = new WP_Query( array ( 'orderby' => 'rand', 'posts_per_page' => '1', 'monthnum' => $i ));
				// Loop
				while($cover->have_posts()):
					 $cover->next_post();
					 $id = $cover->post->ID;
 		             $custom = get_post_custom($id);
           $path = preg_replace('/\.(.{3})$/','-150x150.$1',$custom['book_cover_url'][0]);
					 echo "<img src ='$path'><br>";
				endwhile;
				echo "$text</a>";
				
            wp_reset_query();
			echo "</td>";
			//if this is the end of a row, close it
			if($i % 3 == 0) echo "</tr>";

		}
			
	}
?>  
  </table>
</div>

<?php include(TEMPLATEPATH."/primary-sidebar.php");?>

<?php get_footer(); ?>
