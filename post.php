<!-- Birthday Banner -->
<div id="birthday">
  <a href="http://us.macmillan.com/childrensbookadayalmanac/AnitaSilvey" onClick=”javascript: pageTracker._trackPageview (‘/outgoing/us.macmillan.com’);">
	<img style="margin-top: -10px; padding-bottom: 20px;" src="<?=get_bloginfo ( 'template_directory' ).'/images/bookaday620x169_2.gif'?>" />
  </a>
</div>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php 
					$custom_data = get_post_custom(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
  		<?php if(!$current_year) {
				$current_year = date('Y');
			}
  		  $search_year = $current_year;
  		  //loop backwards through the years until we find a post for today's date
  		  while($prev_query->post_count < 1){

    		  $current_date = $search_year . get_the_date('-m-d');
    		  $yesterday = strtotime($current_date.' - 1 DAY');

    		  $prev_query = new WP_Query(
    		    "posts_per_page=1&year=".date('Y',$yesterday).
    		    "&monthnum=".date('m',$yesterday).
    		    "&day=".date('d',$yesterday));
    		  $search_year = $search_year - 1;

  
    		  //We started in 2010 so no point in looking earlier than that.
    		  if($search_year < 2010) {
    		    break;
    		  }
  		  }  
  		  
  		  //And now we do it again for tomorrow
         $search_year = $current_year;
    		  while($next_query->post_count < 1){

      		  $current_date = $search_year . get_the_date('-m-d');
      		  $tomorrow = strtotime($current_date.' + 1 DAY');
           
      		  $next_query = new WP_Query(
      		    "posts_per_page=1&year=".date('Y',$tomorrow).
      		    "&monthnum=".date('m',$tomorrow).
      		    "&day=".date('d',$tomorrow));
      		  $search_year = $search_year - 1;

      		  //We started in 2010 so no point in looking earlier than that.
      		  if($search_year < 2010) {
      		    break;
      		  }
			}
  		  ?>
  		  <div id="prev-next">
  		    <div class="prev">
  		      <a href="<?=get_permalink($prev_query->post->ID);?>?y=<?=$current_year?>"><img src="<?= get_bloginfo( 'template_directory' ).'/images/yesterday.png'; ?>"></a>
  		     </div>
  		     <div class="next">
  		       <a href="<?=get_permalink($next_query->post->ID);?>?y=<?=$current_year?>"><img src="<?= get_bloginfo( 'template_directory' ).'/images/tomorrow.png'; ?>"></a>
  		     </div>
  		  </div>
  		
		  <div id="heading">
		  <div class="today"><?php $npost = get_next_post(false, null); if(!$npost) { echo "TODAY"; }?></div>
			  <div class="month"><?=strtoupper(get_the_time('F')) ?></div>
			  <div class="day"><?php the_time('j') ?></div>
			  <?php if($title = $custom_data['book_title'][0] ) { ?>
			      <div class="title"><a href="<?=the_permalink()?>"><?=$custom_data['book_title'][0]?></a></div>
			      <div class="author">by <a href="/author/?b=<?=$custom_data['book_author'][0]?>"><?=$custom_data['book_author'][0]?></a></div>
				  <div class="illustrator">
					<?php if($illustrator =  $custom_data['book_illustrator'][0]){
					    echo "Illustrated by <a href='/author/?b=$illustrator'>$illustrator</a>";
					    } ?>
				  
				  </div>
			  <?php } else if ($author = $custom_data['book_author'][0]) { ?>
			      <div class="title"><a href="<?=the_permalink()?>"><?=$author?></a></div>
			  <?php } else if ($illustrator =  $custom_data['book_illustrator'][0]) {?>  
				   <div class="title"><a href="<?=the_permalink()?>"><?=$illustrator?></a></div>
			  <?php } else { ?>
				<div class="title"><a href="<?=the_permalink()?>"><?=$custom_data['topic'][0]?></a></div>
			  <?php } ?>
			  <div class="categories"><?php the_tags('', ' &bull; '); ?></div>
			 </div>
			<div id="cover">
			  <img src="<?=$custom_data['book_cover_url'][0]?>">
			</div>
			<div class="entry">
						<div id="today-in-history">
			<div  class="tih-content">
			<h2>A FEW OTHER EVENTS FOR <br><span><?=strtoupper(get_the_time('F j'))?></span>:</h2>		
			  <ul>
            <?php
            foreach($custom_data['this_day_in_history'] as $trivia) echo "<li><span>$trivia</span></li>" ?>
            </ul>
			</div>
			<div class="tih-footer"></div>
      </div>
			<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>

			
			<?php if($custom_data['also_rec']) { ?>
			    <div id="also-recommended">
          <strong>Also recommended:</strong> <?php foreach($custom_data['also_rec'] as $key=>$title){
            echo "<span class='title'>$title</span>";
            if($key < sizeof($custom_data['also_rec'])-1) echo '<span class="dot">&bull;</span>';
          }?> 
          </div>
      <?php } ?>
			
			<?php if($custom_data['flex_data']) { ?>
			    <div id="flex">
				<?php if($custom_data['flex_label']){ ?>
					<strong><?=$custom_data['flex_label'][0]?></strong> 
				<?php } ?>
				<?=$custom_data['flex_data'][0] ?>
				</div>
			
			<?php } ?>
		<?php //Originally Posted ?>	
		<div style="clear:both"><p>
          Originally posted <?php the_date('F j, Y')?>. 
		  <?php if (get_the_date('Y') != $current_year) {
			?>Updated for <?=$current_year?>.
          <?php } ?>
		  </p></div>

		<?php // Tags ?>
  		<div id="post-tags">
			<strong>Tags</strong>: <?php the_category( ', '); ?>
       	</div>

		<?php // Teaching Books 
		if($custom_data['teachingbooks']): ?>
			<div id="teaching-books" style="clear:both">
				<strong>TeachingBooks.net</strong> for <a href="<?=$custom_data['teachingbooks'][0]?>"><?=$custom_data['book_title'][0]?></a>
			</div>
		<?php endif; ?>
		
		<?php //One Year Ago 
		$last_year = strtotime(get_the_date('Y-m-d').' - 1 YEAR');

  		$last_query = new WP_Query(
  		    "posts_per_page=1&year=".date('Y',$last_year).
  		    "&monthnum=".date('m',$last_year).
  		    "&day=".date('d',$last_year));
  		if($last_query->post_count > 0): ?>
			<div id="one-year-ago"><strong>One year ago:</strong> <a href="<?=get_permalink($last_query->post->ID);?>">
				<span class="title"><em><?=$last_query->post->post_title ?></em></span></a>
		</div>
		<?php endif;  ?>

		<?php 
		// Sharing 
		if( function_exists(do_sociable) ){ do_sociable(); } ?>
         
		 
		 <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
       

		


      
			</div>

      
			
		</div>
		

<?php $withcomments = 1; ?>
  <h2 class="green_bar">COMMENTS</h2>
	<?php comments_template(); ?>

	<?php endwhile; else: ?>

		<div class="post">
			<h2 class="center">Not Found</h2>
			<p class="center">Sorry, but you are looking for something that isn't here.</p>
		</div>

<?php endif; ?>

