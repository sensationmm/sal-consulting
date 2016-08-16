<?php
/**
 * @package WordPress
 * @subpackage SAL Consulting 2015
*/
get_header();  

//check for page level overrides
$styleOverride = get_field('override_style', 158);
if($styleOverride != '')
	$style = $styleOverride;
$styleIconOverride = get_field('override_icon', 158);
if($styleIconOverride != '')
	$styleIcon = $styleIconOverride;
?>
	<div class="strap">
		<div class="body">
			<?php $blogTitle = get_page(158); $parent = get_page($blogTitle->post_parent); ?>
			<h1 style="background-image:url(<?php echo $styleIcon; ?>);"><?php echo $blogTitle->post_title; ?></h1>
		</div>
	</div>

	<div class="body">

		<article class="col-main blog">
			<?php 
				$img = get_post_thumbnail_id(get_the_ID());
				$imgURL = wp_get_attachment_url($img);
				if($imgURL != '')
					echo '<div class="blog-banner"><img src="'.$imgURL.'" /></div>';
				echo '<div class="blog-content">';
				echo '<h2>'.$pageObj->post_title.'</h2>';
				echo '<div class="blog-date">'.get_the_date('j F Y').'</div>';
				echo apply_filters('the_content', $pageObj->post_content); 
				$author = get_userdata($pageObj->post_author);

				$pic = get_field('author_photo', 'user_'.$author->ID);
				if($pic == '')
					$pic = get_avatar($author->ID);
				else
					$pic = '<img src="'.$pic.'" title="'.$author->first_name.' '.$author->last_name.'" />';

				echo '<div class="blog-author">';
				echo '<div class="blog-avatar"><a href="'.get_author_posts_url($author->ID).'" title="View more articles by '.$author->first_name.' '.$author->last_name.'">'.$pic.'</a></div>';
				echo '<a href="'.get_author_posts_url($author->ID).'" title="View more articles by '.$author->first_name.' '.$author->last_name.'">Article by '.$author->first_name.' '.$author->last_name.'</a>';
				echo '</div>';

				echo '<div class="blog-prev">';previous_post_link('%link', 'Previous article'); echo '</div>';
				echo '<div class="blog-next">';next_post_link('%link', 'Next article'); echo '</div>';
				echo '</div>';
			?>
		</article>
		
		<div class="col-left">
			<?php include 'include-blog-menu.php'; ?>
		</div>
	</div>

<?php get_footer(); ?> 