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
<div class="primary-sidebar <?php if ($et_threecolumn_disable == "false") { ?> <?php echo $et_columnorder; ?> <?php } else { ?> content-two-column<?php echo $et_columnorder; ?> <?php } ?>">
	<a href="/">
		<img class="logo" border="0" src="<?php bloginfo('template_directory'); ?>/images/bookaday_270.png" />
	</a>
<div class="tagline">
<p>
Daily children’s book recommendations and events from Anita Silvey.</p>
<p>
Discover the stories behind the children’s book classics . . .</p>
<p>
The new books on their way to becoming classics . . .</p>
<p>
And events from the world of children’s books—and the world at large.</p>
</div>

<ul>
<?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar('Primary Sidebar') ) : ?>
        
		<li><h2>Search</h2>
		<?php get_search_form(); ?></li>
			
    <?php if (function_exists('aktt_sidebar_tweets')) { ?>
    <li><h2>What I'm Doing...</h2>
		<?php aktt_sidebar_tweets(); ?></li>
	<?php } ?>

<?php wp_list_pages('title_li=<h2>Pages</h2>' ); ?>


<li><h2>Meta</h2>
	<ul>
		<?php wp_register(); ?>
		<li><?php wp_loginout(); ?></li>
		<li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress</a></li>
		<?php wp_meta(); ?>
	</ul>
</li>

<?php endif; ?>

</ul>

</div>

