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

   <div class="content <?php if ($bada_threecolumn_disable == "false") { ?> <?php echo $bada_columnorder; ?> <?php } else { ?> content-two-column<?php echo $bada_columnorder; ?> <?php } ?>">

<?php
date_default_timezone_set(get_option('timezone_string'));
?>

<?php
include(TEMPLATEPATH."/post.php");?>
	

	</div>


<?php include(TEMPLATEPATH."/primary-sidebar.php");?>

<?php get_footer(); ?>
