<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php 
					$custom_data = get_post_custom(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<div id="prev-next">
		    <div class="prev">
		      <?php previous_post_link("%link",'<img src="'.get_bloginfo ( 'template_directory' ).'/images/yesterday.png">'); ?>
		     </div>
		     <div class="next">
		       <?php next_post_link("%link",'<img src="'.get_bloginfo ( 'template_directory' ).'/images/tomorrow.png">'); ?>
		     </div>
		  </div>		  <div id="heading">
		  <div class="today"><?php $npost = get_next_post(false, null); if(!$npost) { echo "TODAY"; }?></div>
			  <div class="month"><?=strtoupper(get_the_time('F')) ?></div>
			  <div class="day"><?php the_time('j') ?></div>
			  <?php if($title = $custom_data['book_title'][0] ) { ?>
			      <div class="title"><?=$custom_data['book_title'][0]?></div>
			      <div class="author">by <?=$custom_data['book_author'][0]?></div>
			  <?php } else { ?>
			      <div class="title"><?=$custom_data['book_author'][0]?></div>
			  <?php } ?>  
			  <div class="illustrator">
			    <?php if($illustrator =  $custom_data['book_illustrator'][0]) echo "Illustrated by $illustrator" ?>
			  </div>
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
  		<div id="post-tags">
				<strong>Tags</strong>: <?php the_category( ', '); ?>
         	</div>
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

