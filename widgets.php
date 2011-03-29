<?php
/*
Plugin Name: Book-A-Day Widgets
Plugin URI: http://www.kellbot.com/
Description: Special widgets for Book-A-Day Almanac
Author: Kelly Farrell
Version: 1
Author URI: http://www.kellbot.com/
*/

//returns an array of the 1 (or $limit) posts next 
function widget_next_posts($limit=1){
	global $wp_query;
	global $wpdb; 
	
	$post_date = current_time('mysql');
	 $querystr = "
	    SELECT wposts.* 
	    FROM $wpdb->posts wposts
	    WHERE
	    wposts.post_status IN ('publish','future')
	    AND wposts.post_type = 'post' 
	    AND wposts.post_date > '$post_date'
	    ORDER BY wposts.post_date ASC
	     LIMIT $limit 
	 ";

	 $pageposts = $wpdb->get_results($querystr, OBJECT);
 


	 return $pageposts;
}
//returns an array of the 5 (or $limit) posts previous 
function widget_previous_posts($limit=1){
	global $wp_query;
	global $wpdb; 
	
	$post_id = $wp_query->post->ID;
	$post_date = $wp_query->post->post_date;
	
	 $querystr = "
	    SELECT wposts.* 
	    FROM $wpdb->posts wposts
	    WHERE
	    wposts.post_status = 'publish' 
	    AND wposts.post_type = 'post' 
	    AND wposts.post_date < '$post_date'
	    ORDER BY wposts.post_date DESC
	    LIMIT $limit
	 ";

	 $pageposts = $wpdb->get_results($querystr, OBJECT);
 


	 return $pageposts;
}

function widget_post_widget_previous($args) {
	
	
	extract($args);
  echo $before_widget;
  echo $before_title;?>Previous Books<?php echo $after_title;


  $previous_posts = widget_previous_posts();
  
  echo '<ul class="booklist">';
  if(sizeof($previous_posts)==0) echo "You've reached the first book";
  foreach ($previous_posts as $prev_post){
  	  echo "<li><a href='".get_permalink($prev_post->ID)."'>$prev_post->post_title</a></li>";	  
  }
  echo '</ul>';

  echo $after_widget;
}
 function widget_post_widget_next($args) {
	
	
	extract($args);
  echo $before_widget;
  echo $before_title;?>COMING UP<?php echo $after_title;

  $next_posts = widget_next_posts();
  echo '<ul class="booklist">';
  foreach ($next_posts as $next_post){
  	  $custom = get_post_custom($next_post->ID);
  	  echo "<li>";
  	  #$arrImages =& get_children('post_type=attachment&post_mime_type=image&post_parent=' . $next_post->ID );
  	  #$first_image = array_pop($arrImages);
  	  $path = preg_replace('/\.(.{3})$/','-150x150.$1',$custom['book_cover_url'][0]);
  	  echo "<img src='$path'>";

  	  echo "</li>";
  }
  echo '</ul>';

  echo $after_widget;
}
function widget_book_info($args){
	global $wp_query;
	global $wpdb; 
	
	extract($args);
	$custom = get_post_custom($wp_query->post->ID);
	echo "<h2 class='widgettitle'>".$custom['book_title'][0]."</h2>";
	echo '<img src="'.$custom['book_cover_url'][0].'">';
	echo '<p>'.$custom['book_author'][0];
	if($custom['book_illustrator']) echo '<br>Illustration by '.$custom['book_illustrator'][0];
	echo '</p>';
	echo '<p>Categories: ';
	$categories = get_the_category();
	$i=1;
	foreach($categories as $category){
		echo "<a href='?cat=$category->cat_ID'>$category->cat_name</a>";
		if($i<sizeof($categories)) echo ', ';
		$i++;
	}

  echo $before_widget;
  echo $after_widget;
}
function widget_also_rec($args){
	global $wp_query;
	global $wpdb; 
	extract($args);	

	echo $before_widget;
	echo $before_title;?>Also Recommended<?php echo $after_title;


	$custom = get_post_custom($wp_query->post->ID);
	$books = explode("\n",$custom['also_rec'][0]);
	foreach ($books as $book){
		echo $book.'<br>'; 	
	}
	echo '</p>';
	

  echo $after_widget;
}

function widget_on_this_day($args){
	global $wp_query;
	global $wpdb; 
	extract($args);	

	echo $before_widget;
	echo $before_title;?>On This Day In History<?php echo $after_title;


	$custom = get_post_custom($wp_query->post->ID);
	$facts =$custom['this_day_in_history'];
	echo "<ul>\n";
	if(sizeof($facts)>0){
		foreach ($facts as $fact){
			echo "<li>$fact</li>"; 	
		}
	}
	echo '</ul>';
	

  echo $after_widget;
}

function highlight_first_sentence($content) {
  return preg_replace('/.+\.\s/','<span class="highlight">${1}</span>',$content,1);
}

function widget_archives_box($args){
	extract($args);
	echo $before_widget;
	echo $before_title;
	echo "Find A Book!";
	echo $after_title;
	
	echo "<script type='text/javascript'>
	$(function() {
		$('#find-a-book').click(function(){
			window.location = '/archive';
		});
	});
	</script>";
	echo "<ul>";
	echo "<li><img src='".get_bloginfo('template_directory')."/images/book1.png'></li>";
	echo "<li><img src='".get_bloginfo('template_directory')."/images/book2.png'></li>";
	echo "<li><img src='".get_bloginfo('template_directory')."/images/book3.png'></li>";
	echo "</ul>";
	echo "<p>Search the archives for recommendations by age group, book type, subject, date, and more.</p>";
	echo $after_widget;
}

function widget_tools($args){
	extract($args);
	echo $before_widget;
	echo $before_title;
	echo "Tools";
	echo $after_title;
	echo "<div><span class='tool-label'>SUBSCRIBE</span>";
	echo "<a href='".get_bloginfo('rss2_url')."'><img src='".get_bloginfo('template_directory')."/images/feed_icon_9.png'></a> ";
	echo "<a href='https://www.facebook.com/pages/Childrens-Book-a-Day-Almanac/124782870923569'><img src='".get_bloginfo('template_directory')."/images/facebook_icon_4.png'></a> ";
	echo "<a href='http://twitter.com/anitasilvey'><img src='".get_bloginfo('template_directory')."/images/icon_twitter.png'></a>";

	echo "</div>";
	echo '<div><span class="tool-label">SEARCH</span> <form action="/" method="get" id="searchform">
<input type="text" size="10" name="s" id="s" />
<input type="submit" id="searchsubmit" value="GO" style="padding: 3px" class="btn" />
</form></div>';
	echo $after_widget;
}

function display_cover_in_rss($rss_content) {
    global $post;
    $custom = get_post_custom($post->ID);
     $cover = '<div style="float : left;margin-right:10px;">'.'<img src="'.$custom['book_cover_url'][0].'">'.'</div>';

        $rss_content= $cover.$rss_content;
    
    return $rss_content;
}
add_filter('the_content_feed', 'display_cover_in_rss');

add_filter('the_excerpt_rss', 'display_cover_in_rss');


function previous_posts_init()
{
  register_sidebar_widget(__('Previous Posts'), 'widget_post_widget_previous');
}
function next_posts_init()
{
  register_sidebar_widget(__('Coming Up'), 'widget_post_widget_next');
  register_sidebar_widget(__('Find a Book'), 'widget_archives_box');
  register_sidebar_widget(__('Tools'), 'widget_tools');
}
function book_info_init()
{
  register_sidebar_widget(__('Book Information'), 'widget_book_info');
}
function also_rec_init()
{
  register_sidebar_widget(__('Also Recommended'), 'widget_also_rec');
}
function this_day_init(){
    register_sidebar_widget(__('On This Day'),'widget_on_this_day');
}

add_action("plugins_loaded",'book_info_init');
add_action("plugins_loaded",'this_day_init');
add_action("plugins_loaded", "previous_posts_init");
add_action("plugins_loaded", "next_posts_init");
add_action("plugins_loaded", "also_rec_init");
//add_filter("the_content","highlight_first_sentence",1);


