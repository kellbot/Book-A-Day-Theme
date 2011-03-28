<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/images/favicon.jpg" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
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
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery-1.2.3.min.js"></script> 
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/menu.js"></script> 
<script type="text/javascript">
function equalHeight(group) {
	var tallest = 0;
	group.each(function() {
		var thisHeight = $(this).height();
		if(thisHeight > tallest) {
			tallest = thisHeight;
		}
	});
	group.height(tallest);
}

$(document).ready(function (){
    equalHeight($('.content-two-columncontent-right'));
});
</script>
<?php wp_head(); ?>
</head>
<body>


<div id="container">


<div id="header">
	<div class="logo">
		<h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
		<h2><?php bloginfo('description'); ?></h2>
	</div>
</div>

<?php /* Hide or show about section */
if ($et_headerimage_disable == "true") { ?>
<div id="headerimg">
<h2><?php bloginfo('description'); ?></h2></div>
<?php } ?>

<!--
<div id="menu">
	<ul id="dropmenu">
		<li class="<?php if (is_home()) { ?>current_page_item<?php } else { ?>page_item<?php } ?>"><a href="<?php bloginfo('url'); ?>" title="Home">Home</a></li>
		<?php wp_list_pages('title_li=&sort_column=menu_order&depth=4');   ?>
	</ul>
</div>
-->
