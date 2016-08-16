<?php
/**
 * @package WordPress
 * @subpackage SAL Consulting 2015
*/
get_header();  

//check for page level overrides
$styleOverride = get_field('override_style', 154);
if($styleOverride != '')
	$style = $styleOverride;
$styleIconOverride = get_field('override_icon', 154);
if($styleIconOverride != '')
	$styleIcon = $styleIconOverride;
?>

	<div class="strap">
		<div class="body">
			<?php $eventTitle = get_page(154); $parent = get_page($jobTitle->post_parent); ?>
			<h1 style="background-image:url(<?php echo $styleIcon; ?>);"><?php echo $eventTitle->post_title; ?></h1>
		</div>
	</div>

	<div class="body">
		<article class="col-main">
		<?php
			echo '<h2>'.$pageObj->post_title.'</h2>';
			echo apply_filters('the_content', $pageObj->post_content);
		?>
		</article>

		<section class="col-right">

			<h2>Register for this event</h2>
			<p>Call us on <?php echo $variablesArray['telephone']; ?> or use the form below to register for <strong><?php echo $pageObj->post_title; ?></strong>.</p>
			<?php echo do_shortcode('[contact-form-7 id="237" title="Event Registration"]'); ?>
		</section>
	</div>

	<?php get_footer(); ?> 