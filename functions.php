<?php
if ( function_exists('register_sidebar') ) {
	register_sidebar( array('name'=>'Primary Sidebar') );
	register_sidebar( array('name'=>'Secondary Sidebar') );
}
if (function_exists('add_image_size') ) {
	add_image_size('tiny-thumbnail', 85, 85, FALSE);
}

?>
<?php
function widget_bada_search() {
?>
<h2>Search</h2>
<form id="searchform" method="get" action="<?php bloginfo('home'); ?>/"> <input type="text" value="type, hit enter" onfocus="if (this.value == 'type, hit enter') {this.value = '';}" onblur="if (this.value == '') {this.value = 'type, hit enter';}" size="18" maxlength="50" name="s" id="s" /> </form> 
<?php
}
if ( function_exists('register_sidebar_widget') )
    register_sidebar_widget(__('Search'), 'widget_bada_search');
?>
<?php
function bada_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
     <div id="comment-<?php comment_ID(); ?>">
      <div class="comment-author vcard">
         <?php echo get_avatar($comment,$size='48',$default='<path_to_url>' ); ?>

         <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
      </div>
      <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Your comment is awaiting moderation.') ?></em>
         <br />
      <?php endif; ?>

      <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','') ?></div>

      <?php comment_text() ?>

      <div class="reply">
         <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
      </div>
     </div>
<?php
        }

?>
<?php
function footer_wp_link() {
    return 'Powered by <a href="http://WordPress.org/" title="WordPress">WordPress</a>';
}
add_shortcode('wp-link', 'footer_wp_link');	

function footer_credit_link() {
    return 'Development by <a href="http://www.kellbot.com/" title="Kellbot">Kellbot!</a>';
}
add_shortcode('credit-link', 'footer_credit_link');	

function footer_copy_text() {
    return '&copy; '  . date('Y') .' '. get_bloginfo('name') .'';
}
add_shortcode('copyright-text', 'footer_copy_text');	

function footer_all_rights() {
    return 'All Rights Reserved';
}
add_shortcode('all-rights', 'footer_all_rights');	

function footer_built_on() {
    return 'Built on <a href="http://empirethemes.com/et-starter/">ET-Starter</a>';
}
add_shortcode('built-on', 'footer_built_on');	

?>
<?php
$themename = "Book-A-Day-Almanac";
$shortname = "bada";

$options = array (	
			
	array(	"type" => "open"),
			
	array(	"name" => "Text in Footer:",
			"desc" => "You can use the following shortcodes in your footer: [copyright-text] [all-rights-reserved] [wp-link] [credit-link] [built-on]",
            "id" => $shortname."_footer_info",
            "std" => "[copyright-text]. [all-rights]. [wp-link]. [credit-link].",
            "type" => "textarea"),
    
    array(	"type" => "close"),
   
	array(	"type" => "open"),
    
   	array(	"name" => "Google Analytics Code:",
			"desc" => "Paste your Google Analytics code here",
            "id" => $shortname."_google",
            "type" => "textarea"),
    
    array(	"type" => "close"),
	
	array(	"type" => "open"),
	
	array(  "name" => "Would you like a two column theme?",
			"desc" => "Yes, if checked.",
            "id" => $shortname."_threecolumn_disable",
            "type" => "checkbox",
            "std" => "false"),
	
	array(	"type" => "close"),

	array(	"type" => "open"),
	
	array( "name" => "Main Content Order",
			"desc" => "If you have two columns activated, 'secondary sidebar' is removed from column order and content-middle turns into single column theme",
			"id" => $shortname."_columnorder",
			"options" => array("content-middle", "content-left", "content-right"),
			"std" => "content-middle",
			"type" => "select"),
			
	array(	"type" => "close"),
			
	array(	"type" => "open"),
	
	array(  "name" => "Display Header Image?",
			"desc" => "Yes, if checked.",
            "id" => $shortname."_headerimage_disable",
            "type" => "checkbox",
            "std" => "false"),
	
	array(	"type" => "close"),

			

);



function bada_add_admin() {

    global $themename, $shortname, $options;

    if ( $_GET['page'] == basename(__FILE__) ) {
    
        if ( 'save' == $_REQUEST['action'] ) {

                foreach ($options as $value) {
                    update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }

                foreach ($options as $value) {
                    if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }

                header("Location: themes.php?page=functions.php&saved=true");
                die;

        } else if( 'reset' == $_REQUEST['action'] ) {

            foreach ($options as $value) {
                delete_option( $value['id'] ); }

            header("Location: themes.php?page=functions.php&reset=true");
            die;

        }
    }

    add_theme_page(Theme." Options", "".Theme." Options", 'edit_themes', basename(__FILE__), 'bada_admin');

}

function bada_admin() {

    global $themename, $shortname, $options;

    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
    if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
    
?>
<div class="wrap">
<h2 style="font-style:normal;">Theme Options</h2>

<div style="width:600px; overflow:hidden;">

<div>

<div style="background:#dcf3db; padding:10px 20px; margin:20px 0; border:1px solid #c9e6c8; -moz-border-radius: 6px; -khtml-border-radius: 6px; -webkit-border-radius: 6px; border-radius: 6px;"><p>Thank you for downloading our <strong><i><?php echo $themename; ?></i></strong> WordPress theme. Need help? Please visit our <a href="http://empirethemes.com/forums/">Forums</a>.</p></div>

<div  style="background:#fbfbfa; border:1px solid #efefef; -moz-border-radius: 6px; -khtml-border-radius: 6px; -webkit-border-radius: 6px; border-radius: 6px;">
<h3 style="font:normal 18px georgia; background:#f1f1f1; margin:0; padding:10px 20px;">License Information</h3>

<div  style="padding:20px;">

<h3 style="font:normal 14px georgia; margin:0; padding:0;">Credit Links</h3>
<p>Our credit links are not required to remain intact, but is appreciated.</p>

<h3 style="font:normal 14px georgia; margin:0; padding:0;">License</h3>
<p>Our themes are released under the GPL license. Which allows you to use our themes for personal and commercial projects.</p>


</div>
</div>

<div style="background:#fbfbfa;  margin:20px 0 20px 0;border:1px solid #e6e6e6; -moz-border-radius: 6px; -khtml-border-radius: 6px; -webkit-border-radius: 6px; border-radius: 6px;">
<h3 style="font:normal 18px georgia; background:#f1f1f1; margin:0; padding:10px 20px;">Theme Settings</h3>
<div style="padding:20px;">
<form method="post">



<?php foreach ($options as $value) { 
    
	switch ( $value['type'] ) {
	
		case "open":
		?>
		 <table width="100%" border="0" style="padding:10px 0;">
		
        
        
		<?php break;
		
		case "close":
		?>
		</table><div style="margin:0 0 4px 0; padding:0 0 4px 0; border-bottom:1px solid #e9e9e9;"></div>
   
        
        
		<?php break;
		
		case "title":
		?>
		<table width="100%" border="0" ><tr>
        	<td colspan="2"><h3 style="font-family:Georgia,'Times New Roman',Times,serif;"><?php echo $value['name']; ?></h3></td>
        </tr>
                
        
		<?php break;

		case 'text':
		?>
        
        <tr>
            <td width="40%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
            <td width="60%"><input style="width:400px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></td>
        </tr>

        <tr>
            <td><small><?php echo $value['desc']; ?></small></td>
        </tr><tr><td colspan="2" style="margin-bottom:5px;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>

		<?php 
		break;
		
		case 'textarea':
		?>
        
        <tr>
            <td width="40%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
            <td width="60%"><textarea name="<?php echo $value['id']; ?>" style="width:400px; height:100px;" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?></textarea></td>
            
        </tr>

        <tr>
            <td><?php echo $value['desc']; ?></td>
        </tr>

		<?php 
		break;
		
		case 'select':
		?>
        <tr>
            <td width="40%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
            <td width="60%"><select name="<?php echo $value['id']; ?>" style="width:150px;" id="<?php echo $value['id']; ?>"><?php foreach ($value['options'] as $option) { ?><option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?></select><?php echo $value['notes']; ?></td>
       </tr>
                
       <tr>
            <td><?php echo $value['desc']; ?></td>
       </tr>
		

		<?php
        break;
            
		case "checkbox":
		?>
            <tr>
            <td width="40%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                <td width="60%"><? if(get_settings($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = ""; } ?>
                        <input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
                        <?php echo $value['desc']; ?> <?php echo $value['notes']; ?>
                        </td>
            </tr>
                      
           

        
        
		<?php
        break;
            
		case "input":
		?>
			<tr>
				 <td width="40%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
				<td width="60%">
				<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if (get_settings($value['id']) != "") { echo get_settings($value['id']); } else { echo $value['std']; } ?>" style="border: 1px solid #DDDDDD"/>
				<?php echo $value['notes']; ?>
				</td>
			</tr>
            
            
            
        <?php 		break;
	
 
} 
}
?>

</table>

<p class="submit" style="clear:left;">
<input name="save" type="submit" class="button-primary" value="Save changes" />    
<input type="hidden" name="action" value="save" />
</p>
</div>
</form>
</div>
</div>

</div>
</div>
</div>
<?php
}

add_action('admin_menu', 'bada_add_admin'); ?>
<?php
define('HEADER_TEXTCOLOR', '');
define('HEADER_IMAGE', '%s/images/header.jpg'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 450);
define('HEADER_IMAGE_HEIGHT', 246);
define( 'NO_HEADER_TEXT', true );

function starter_admin_header_style() {
?>
<style type="text/css">
#headimg {
	background: #fff url(<?php header_image() ?>) no-repeat;
}
#headimg {
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
}

#headimg h1, #headimg #desc {
	display: none;
}
</style>
<?php
}
function starter_header_style() {
?>
<style type="text/css">
#headerimg {
	background:#fff url(<?php header_image() ?>) no-repeat;
}
</style>
<?php
}
if ( function_exists('add_custom_image_header') ) {
	add_custom_image_header('starter_header_style', 'starter_admin_header_style');
}

add_filter('query_vars', 'parameter_queryvars' );
function parameter_queryvars( $qvars )
{
$qvars[] = 'archive_month';
return $qvars;
}

add_action('pre_get_posts', post_repeater);
function post_repeater($query){
	$today = getdate();
	if ($query->is_home() &&  $query->is_main_query()){
		$query->set('monthnum',$today["mon"]);
		$query->set('day',$today["mday"]);
		$query->set('posts_per_page',1);
	}
}

//template tag for showing the link to tomorrow's post
function bada_tomorrow_link($post_date){
	
	$tomorrow = strtotime($post_date . ' + 1 day');
	$tomorrow_query = new WP_Query(
      		    "posts_per_page=1&monthnum=".date('m', $tomorrow) .
      		    "&day=" . date('d', $tomorrow));
 
	wp_reset_postdata();
	$base_link = get_permalink($tomorrow_query->post->ID);
	return $base_link;
}

function bada_yesterday_link($post_date){
	
	$yesterday = strtotime($post_date . ' - 1 day');
	$yesterday_query = new WP_Query(
      		    "posts_per_page=1&monthnum=".date('m', $yesterday) .
      		    "&day=" . date('d', $yesterday));
 
	wp_reset_postdata();
	$base_link = get_permalink($yesterday_query->post->ID);
	return $base_link;
}


?>