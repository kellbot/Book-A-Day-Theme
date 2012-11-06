<?php
/*
Template Name: Date Archives
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
<?        global $wpdb, $wp_locale;

     	$where = apply_filters('getarchives_where', "WHERE post_type = 'post' AND post_status = 'publish'");
		$query = "SELECT MONTH(post_date) AS `month`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY MONTH(post_date) ORDER BY post_date DESC $limit";
		$key = md5($query);
		$cache = wp_cache_get( 'wp_get_archives' , 'general');
		if ( !isset( $cache[ $key ] ) ) {
				$arcresults = $wpdb->get_results($query);
				$cache[ $key ] = $arcresults;
				wp_cache_set( 'wp_get_archives', $cache, 'general' );
		} else {
				$arcresults = $cache[ $key ];
		}
		if ( $arcresults ) {
		  
				foreach ( (array) $arcresults as $arcresult ) {
						$url = get_month_link( $arcresult->year, $arcresult->month );
						/* translators: 1: month name, 2: 4-digit year */
						$text = sprintf(__('%1$s %2$d'), $wp_locale->get_month($arcresult->month), $arcresult->year);
						if ( $show_post_count )
								$after = '&nbsp;('.$arcresult->posts.')' . $afterafter;
						$link = get_archives_link($url, "See All", $format, "<span class='allmonth'>","</span>");
						echo get_archives_link($url, $text, $format, '<li>', "$link</li>");
						query_posts( 'monthnum='.$arcresult->month.'&year='.$arcresult->year );
						if ( have_posts() ) : while ( have_posts() ) : the_post();
             $custom = get_post_custom();
         		$cover_path = preg_replace('/\.(.{3})$/','-150x150.$1',$custom['book_cover_url'][0]);
         		?>

         		<div class="post">
         				<img src='<?= $cover_path ?>' class='list-image' style="float: left;">
         		    <div style="margin-left: 155px">
         		      <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
         		        <span class="author">by <?=$custom['book_author'][0]?></span>
         		      </h2>
         				  <p class="archive-excerpt"><?php echo get_the_excerpt(); ?></p>

         		      <?php the_category(', ') ?><br>
         				  <?php if (function_exists('the_tags')) { the_tags('', ', '); } ?>
                  <br>
                  Featured on <?php the_date(); ?>
                </div>
         			</div><?php
            endwhile;
            endif;
            wp_reset_query();
				}
			
		}
?>  
  </ul>
</div>

<?php include(TEMPLATEPATH."/primary-sidebar.php");?>

<?php get_footer(); ?>
