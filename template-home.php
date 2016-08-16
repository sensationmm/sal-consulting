<?php
/**
 * @package WordPress
 * @subpackage SAL Consulting 2015
 * Template Name: Home
*/
get_header();  
?>
	
	<div class="banner">
		<div class="body">
			<h1>We work with vulnerability and complexity</h1>
			<div class="features">
			<?php
    			$features = wp_get_nav_menu_items('banner');
    			if(sizeof($features) > 0) {
    				for($i=0; $i<sizeof($features); $i++) {
    					$navPage = get_field('_menu_item_object_id', $features[$i]->ID);
    					$navPage = get_post($navPage);

    					$navStyle = get_section_style($navPage->ID);
    					
    					echo '<div class="feature" id="section'.ucfirst($navStyle).'" rel="'.get_permalink($navPage->ID).'">';
						echo '<h2>'.$features[$i]->title.'</h2>';
						echo '<a rel="'.$navPage->ID.'" class="button section'.ucfirst($navStyle).'" href="'.get_permalink($navPage->ID).'" title="Go to '.$navPage->post_title.'">';
						echo 'More</a>';
						echo '</div>';
	    			}
	    		}
    		?>
    		<div class="mega-menu"></div>
    		<div class="mega-menu-pip"></div>
			</div>
		</div>
	</div> 

	<div class="body">
		<div class="col3">
			<h2 class="col">Upcoming Events</h2>
			<?php
				$listings = array('post_type' => 'event',
								  'posts_per_page' => 3,
								  'orderby' => 'meta_value',
								  'meta_key' => 'event_date'
								 );

				$events = new WP_Query($listings);
				if ($events->have_posts() ) : 
					while ( $events->have_posts() ) : $events->the_post();
						echo '<article class="recent-event">';
						$date = get_field('event_date', get_the_ID());
							echo '<div class="event-date">'.date('d', strtotime($date)).'<span>'.date('M', strtotime($date)).'</span></div>';
							echo '<div class="event-info">';
							echo '<h3><a class="readmore" href="'.get_the_permalink().'">';the_title(); echo '</a></h3><br />';
							$excerpt = get_the_content();
							$excerpt = strip_tags($excerpt);
							if(strlen($excerpt) > 60)
								$excerpt = substr($excerpt, 0, 60).' [...]';
							echo '<p>'.$excerpt.' ';
							echo '<a class="readmore" href="'.get_the_permalink().'" title="Read more">more &gt;</a></p>';
							echo '</div>';
						echo '</article>';
					endwhile;
				endif;
			?>
		</div>

		<div class="col3">
			<h2 class="col">Recent articles</h2>
			<?php
				$listings = array('post_type' => 'post',
								  'posts_per_page' => 3);
				$articles = new WP_Query($listings);
				if ($articles->have_posts() ) : 
					while ( $articles->have_posts() ) : $articles->the_post();
						echo '<article class="recent-blog">';
							echo '<h3><a class="readmore" href="'.get_the_permalink().'" title="Read more">';the_title(); echo '</a></h3>';
							$excerpt = get_the_content();
							$excerpt = strip_tags($excerpt);
							if(strlen($excerpt) > 90)
								$excerpt = substr($excerpt, 0, 90).' [...]';
							echo '<p>'.$excerpt.' ';
							echo '<a class="readmore" href="'.get_the_permalink().'" title="Read more">read more &gt;</a></p>';
						echo '</article>';



					endwhile;
				endif;
			?>
		</div>

		<div class="col3">
			<article>
			<?php
				$aboutTitle = get_field('homeabout_title', $pageObj->ID);
				$aboutText = get_field('homeabout_text', $pageObj->ID);
				$aboutImage = get_field('homeabout_image', $pageObj->ID);
				echo '<h2 class="col">'.$aboutTitle.'</h2>';
				echo '<p>'.$aboutText.'</p>';
				if($aboutImage['url'] != '') {
					echo '<img src="'.$aboutImage['url'].'" alt="'.$aboutImage['alt'].'" />';
				}
			?>
			</article>
		</div>
	</div>

<?php get_footer(); ?> 