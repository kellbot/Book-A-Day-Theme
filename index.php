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

   <div class="content <?php if ($et_threecolumn_disable == "false") { ?> <?php echo $et_columnorder; ?> <?php } else { ?> content-two-column<?php echo $et_columnorder; ?> <?php } ?>">

<?php
/* This is for the circular nature of the almanac. If there's no post for today, look for one today of last year. */
$current_year = date('Y');
$current_month = date('m');
$current_day = date('d');

$show_year = $current_year;

query_posts("monthnum=$current_month&day=$current_day&year=$show_year&posts_per_page=1");
while (!have_posts()){
  $show_year = $show_year-1; 
  wp_reset_query();
  query_posts("monthnum=$current_month&day=$current_day&year=$show_year&posts_per_page=1");
  if ($show_year < 2010) {
    break;
  }
}

include(TEMPLATEPATH."/post.php");?>
	

	</div>


<?php include(TEMPLATEPATH."/primary-sidebar.php");?>

<?php get_footer(); ?>
