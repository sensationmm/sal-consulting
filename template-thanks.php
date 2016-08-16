<?php
/**
 * @package WordPress
 * @subpackage SAL Consulting 2015
 * Template Name: Thanks
*/
get_header();  
?>
	<div class="strap">
		<div class="body">
			<h1 style="background-image:url(<?php echo $styleIcon; ?>);"><?php echo $toplevel; ?></h1>
		</div>
	</div>

	<div class="body">
		<article class="thanks">
			<?php 
				if($pageObj->post_content != '')
					echo apply_filters('the_content', $pageObj->post_content); 
				else echo '<p>NO CONTENT ADDED</p>';
			?>
		</article>
	</div>

<?php get_footer(); ?> 