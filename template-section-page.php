<?php
/**
 * @package WordPress
 * @subpackage SAL Consulting 2015
 * Template Name: Section Page
*/

get_header();  
?>

	<div class="strap">
		<div class="body">
			<h1 style="background-image:url(<?php echo $styleIcon; ?>);"><?php echo $toplevel; ?></h1>
		</div>
	</div>

	<div class="body">

		<article class="col-main">
			<?php
				$breadcrumb = '';
				if($parent->post_title != '' && $parent->ID != $pageObj->ID)
					$breadcrumb = '<li><a href="'.get_permalink($parent->ID).'" title="'.$parent->post_title.'">'.$parent->post_title.' &gt;</a></li>'.$breadcrumb;
				if($grandparent->post_title != '')
					$breadcrumb = '<li><a href="'.get_permalink($grandparent->ID).'" title="'.$grandparent->post_title.'">'.$grandparent->post_title.' &gt;</a></li>'.$breadcrumb;
				if($breadcrumb != '')
					$breadcrumb .= '<li>'.$pageObj->post_title.'</li>';
				echo '<nav class="breadcrumb"><ul>'.$breadcrumb.'</li></nav>';
			?>

			<h2><?php echo $pageObj->post_title; ?></h2>
			<?php 
				if($pageObj->post_content != '')
					echo apply_filters('the_content', $pageObj->post_content); 
				else echo '<p>NO CONTENT ADDED</p>';
			?>
		</article>

		<section class="col-right">
			<h2>Get in touch</h2>
			<?php if($pageObj->ID == 26) {
				echo '<a href="tel://'.$variablesArray['telephone'].'"><div class="call-cta has-strap">Call '.$variablesArray['telephone'].'<span>24 hours / 7 days a week</span></div></a>';
			} ?>
			<p>Call us on <?php echo $variablesArray['telephone']; ?> or use the form below to get in touch about <?php echo $toplevel; ?> services.</p>
			<?php echo do_shortcode('[contact-form-7 id="232" title="Get in touch (Sections)"]'); ?>
		</section>
	</div>

	<?php get_footer(); ?> 