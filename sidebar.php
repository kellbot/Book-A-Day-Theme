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
<div class="sidebar <?php echo $et_columnorder; ?>">
<ul>
<?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar('Secondary Sidebar') ) : ?>
        

<li><h2>Archives</h2>
	<ul>
		<?php wp_get_archives('type=monthly'); ?>
	</ul>
</li>


<?php wp_list_bookmarks(); ?>


<?php endif; ?>

</ul>

</div>

