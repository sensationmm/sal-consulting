<?php
/**
 * @package WordPress
 * @subpackage SAL Consulting 2015
 * Template Name: Events
*/
get_header();  
?>
	<div class="strap">
		<div class="body">
			<h1 style="background-image:url(<?php echo $styleIcon; ?>);"><?php echo $toplevel; ?></h1>
		</div>
	</div>

	<div class="body">
		<?php

			$cats = get_terms(array('taxonomy' => 'event_cats'));

			echo '<div class="filter">';
				echo '<form name="eventsFilter" class="eventsFilter">';
					echo '<div class="select-hold">';
						echo '<select name="event-type" onchange="document.eventsFilter.submit();">';
							echo '<option value="all">Filter</option>';
							foreach($cats as $cat) {
								echo '<option '.(($_GET["event-type"] == $cat->slug) ? 'selected="selected"' : '').' value="'.$cat->slug.'">';
								echo $cat->name.'</option>';
							}
						echo '</select>';
					echo '</div>';
				echo '</form>';
			echo '</div>';
			echo apply_filters('the_content', $pageObj->post_content);

			echo '<div class="events">';
			$listings = array('post_type' => 'event',
							  'posts_per_page' => -1,
							  'orderby' => 'meta_value',
							  'meta_key' => 'event_date'
							 );

			if(isset($_GET["event-type"]) && $_GET["event-type"] != '' && $_GET["event-type"] != 'all') {
				$listings["tax_query"] = array(array('taxonomy' => 'event_cats',
										       'terms' => $_GET["event-type"],
										       'field' => 'slug',
        									   'operator' => 'IN'));
			}

			remove_all_filters('posts_orderby');//prevent plugin clashing with custom ordering
			$events = new WP_Query($listings);

			global $wp_query; 
 			$totalNumResults = ceil(($events->found_posts));

			if ($events->have_posts() ) : 

				echo '<div class="events-row">';
				$count = 0;
				while ( $events->have_posts() ) : $events->the_post();
					$count++;
					echo '<article class="event">';
					$date = get_field('event_date', get_the_ID());
					echo '<div class="event-date">'.date('j F Y', strtotime($date)).'</div>';
					echo '<h2><a href="'.get_permalink(get_the_ID()).'" title="Read '.get_the_title().'">'.get_the_title().'</a></h2>';

					$content = get_the_excerpt();
					$content = strip_tags($content);
					if(strlen($content) > 130)
						$content = substr($content, 0, 130).' [...]';
					echo '<p>'.$content.'</p>';
					echo '<a class="read-more" href="'.get_permalink(get_the_ID()).'" title="Read more of '.get_the_title().'">More</a>';
					echo '</article>';
					if($count%4 == 0) echo '</div><div class="events-row-4">';

				endwhile;


				if($count%4 == 1) echo '<article class="event event-empty">&nbsp;</article><article class="event event-empty">&nbsp;</article><article class="event event-empty">&nbsp;</article></div>';
				else if($count%4 == 2) echo '<article class="event event-empty">&nbsp;</article><article class="event event-empty">&nbsp;</article></div>';
				else if($count%4 == 3) echo '<article class="event event-empty">&nbsp;</article></div>';
				else echo '</div>';
			endif;

		?>
		</div>
	</div>

<?php get_footer(); ?> 