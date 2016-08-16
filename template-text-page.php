<?php
/**
 * @package WordPress
 * @subpackage SAL Consulting 2015
 * Template Name: Text Page
*/
get_header();  
?>
	<div class="strap">
		<div class="body">
			<h1 style="background-image:url(<?php echo $styleIcon; ?>);"><?php echo $toplevel; ?></h1>
		</div>
	</div>

	<div class="body">
		<nav class="col-left">
		<?php include 'include-text-page-menu.php'; ?>
		</nav>

		<article class="col-main">
			<h2><?php echo $pageObj->post_title; ?></h2>
			<?php 
				if($pageObj->post_content != '')
					echo apply_filters('the_content', $pageObj->post_content); 
				else echo '<p>NO CONTENT ADDED</p>';
			?>
		</article>
	</div>

<?php get_footer(); ?> 