<?php
/**
 * @package WordPress
 * @subpackage SAL Consulting 2015
 * Template Name: Contact
*/

get_header();  
?>

	<div class="strap">
		<div class="body">
			<h1 style="background-image:url(<?php echo $styleIcon; ?>);"><?php echo $toplevel; ?></h1>
		</div>
	</div>

	<div class="body">

		<section class="col-right">
			<h2>Find us</h2>
			<a href="tel://<?php echo $variablesArray['telephone']; ?>"><div class="call-cta">Call <?php echo $variablesArray['telephone']; ?></div></a>
			
			<?php $aboutUs = get_page(160); echo apply_filters('the_content', $aboutUs->post_content); ?>
		</section>
		<?php if($pageObj->ID == 160) { ?>
		<article class="col-main box">
			<h2><?php echo $pageObj->post_title; ?></h2>
			<p>To get in touch, call us on <b><?php echo $variablesArray['telephone']; ?></b> or email us using the form below: </p>
			
			<?php echo do_shortcode('[contact-form-7 id="187" title="Contact form 1"]'); ?>
		</article>

		<?php } else { 
			echo '<article class="col-main">';
			echo apply_filters('the_content', $pageObj->post_content);
			echo '</article>';
		} ?>
	</div>

<?php get_footer(); ?> 