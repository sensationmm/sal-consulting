<?php
/**
 * @package WordPress
 * @subpackage SAL Consulting 2015
*/
get_header();  
$pageObj = '';

$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
?>
	<div class="strap">
		<div class="body">
			<?php $blogTitle = get_page(158); $parent = get_page($blogTitle->post_parent); ?>
			<h1 style="background-image:url(<?php echo $styleIcon; ?>);"><?php echo $blogTitle->post_title; ?></h1>
		</div>
	</div>

	<div class="body">

		<div class="col-left">
			<?php include 'include-blog-menu.php'; ?>
		</div>

		<div class="col-main">
		<?php
			echo '<p><strong>Showing articles by '.$author->first_name.' '.$author->last_name.'</strong></p>';

			$listings = array('post_type' => 'post',
							  'posts_per_page' => 8,
							  'author' => $author->ID);

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
					echo '<div class="blog-date">'.get_the_date('d/m/Y').' by ';
					echo '<a href="'.get_author_posts_url(get_the_author_id()).'" title="View more articles by '.get_the_author().'">'.get_the_author().'</a></div>';
					echo apply_filters('the_content', $content);
					echo '<a class="read-more" href="'.get_permalink(get_the_ID()).'" title="Read more of '.get_the_title().'">Read more</a>';
					echo '</div>';
					echo '</article>';

					$repeaterExclude .= get_the_ID().',';
				endwhile;
			endif;


			echo do_shortcode('[ajax_load_more post_type="post" repeater="default" posts_per_page="2" transition="fade" button_label="Load More Articles" scroll="false" pause="true" post__not_in="'.$repeaterExclude.'" author="'.$author->ID.'"]');
		?>
	</div>
	</div>

<?php get_footer(); ?> 