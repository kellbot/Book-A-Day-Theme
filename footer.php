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
<div id="footer">




<p><?php echo do_shortcode("$et_footer_info"); ?></p>

</div>    



</div><!-- end container -->


<?php echo $et_google; ?>
<?php wp_footer(); ?>


</body>
</html>
