<?php
/**
 * @package WordPress
 * @subpackage SAL Consulting 2015
 * Template Name: Blog
*/
get_header();  
?>
	<div class="strap">
		<div class="body">
			<h1 style="background-image:url(<?php echo $styleIcon; ?>);"><?php echo $toplevel; ?></h1>
		</div>
	</div>

	<div class="body">

		<div class="col-main">
		<?php echo apply_filters('the_content', $pageObj->post_content); ?>

		<?php
			$listings = array('post_type' => 'post',
							  'posts_per_page' => 8);
			if(isset($_GET["keywords"]) && $_GET["keywords"] !='') {
				$listings['s'] = $_GET["keywords"];


				echo '<p><strong>Search results for "'.$_GET["keywords"].'"</strong>. <a href="'.get_permalink($blogPage->ID).'" title="Clear search">Clear search</a>.</p>';
			}

			remove_all_filters('posts_orderby');//prevent plugin clashing with custom ordering
			$articles = new WP_Query($listings);

			global $wp_query; 
 			$totalNumResults = ceil(($articles->found_posts));
 			$repeaterExclude = '';
			if ($articles->have_posts() ) : 
				while ( $articles->have_posts() ) : $articles->the_post();
					$img = get_post_thumbnail_id(get_the_ID());
					$imgURL = wp_get_attachment_url($img);

					if($imgURL != '')
						echo '<article class="blog" style="background-image:url('.$imgURL.');">';
					else
						echo '<article class="blog no-image">';
					echo '<div class="blog-content">';
					echo '<h2><a href="'.get_permalink(get_the_ID()).'" title="Read '.get_the_title().'">'.get_the_title().'</a></h2>';

					$content = get_the_excerpt();
					echo '<div class="blog-date">'.get_the_date('j F Y').' by ';
					echo '<a href="'.get_author_posts_url(get_the_author_id()).'" title="View more articles by '.get_the_author().'">'.get_the_author().'</a></div>';
					echo apply_filters('the_content', $content);
					echo '<a class="read-more" href="'.get_permalink(get_the_ID()).'" title="Read more of '.get_the_title().'">Read more</a>';
					echo '</div>';
					echo '</article>';

					$repeaterExclude .= get_the_ID().',';
				endwhile;

				echo do_shortcode('[ajax_load_more post_type="post" repeater="default" posts_per_page="2" transition="fade" button_label="Load More Articles" scroll="false" pause="true" post__not_in="'.$repeaterExclude.'" '.((isset($_GET["keywords"])) ? 'search="'.$_GET["keywords"].'"' : '').']');
			else:
				echo '<h2>Sorry!</h2>';
				echo '<p>There are no results for <strong>'.$_GET["keywords"].'</strong>. Please try again.';
			endif;

		?>
		</div>

		<div class="col-left">
			<?php include 'include-blog-menu.php'; ?>
		</div>
	</div>

<?php get_footer(); ?> 