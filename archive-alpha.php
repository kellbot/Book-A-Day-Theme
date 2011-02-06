<?php
/*
Template Name: Author Archives
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
<?php        global $wpdb, $wp_locale;
        
       
        $where = apply_filters('getarchives_where', "WHERE wposts.ID = wpostmeta.post_id and wpostmeta.meta_key = 'author_sort' and post_type = 'post' AND post_status = 'publish'");
        $orderby = 'meta_value ASC';
        $query = "SELECT wpostmeta.meta_value FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta
        $where ORDER BY $orderby $limit";
        
        $key = md5($query);
        $cache = wp_cache_get( 'wp_get_archives' , 'general');
        if ( !isset( $cache[ $key ] ) ) {
          $authors = $wpdb->get_results($query);
        $cache[ $key ] = $authors;
        wp_cache_set( 'wp_get_archives', $cache, 'general' );
        } else {
          $authors = $cache[ $key ];
        }
		
		$oldletter = null;
		foreach ($authors as $author) { 
		$letter = strtoupper(substr($author->meta_value,0,1));
		if($letter != $oldletter) {
		  if ($oldletter != null) echo "</ul></li>";
		  echo "<li>$letter
		        <ul>";
		  $oldletter = $letter;
		}
		?>
					<li><a href="/author/?a=<?=urlencode($author->meta_value)?>"><?php echo $author->meta_value; ?></a></li>

<?
			
		}
?>  
  </ul>
</div>

<?php include(TEMPLATEPATH."/primary-sidebar.php");?>

<?php get_footer(); ?>
