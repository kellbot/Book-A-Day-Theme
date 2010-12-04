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
<p class="tagline">
Daily children's book recommendations<br> from Anita Silvey<br><?=get_bloginfo ( 'description' );  ?></p>
<hr>
<ul id="navigation">
  <li class="color-1"><a href="/">HOME</a></li>
   <li class="color-2"><a href="/about">ABOUT ANITA</a></li>
  <li class="color-1"><a href="/archive">ARCHIVE</a></li>
</ul>
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

