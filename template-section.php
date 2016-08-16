<?php
/**
 * @package WordPress
 * @subpackage SAL Consulting 2015
 * Template Name: Section
*/
get_header();  
?>

	<div class="strap">
		<div class="body">
			<h1 style="background-image:url(<?php echo $styleIcon; ?>);"><?php echo $pageObj->post_title; ?></h1>
		</div>
	</div>

	<div class="body">
		<article class="col-main">
			<div class="mobile-intro"><?php echo apply_filters('the_content', $pageObj->post_content); ?></div>
			<?php
				function output_title($src) {
					$maxlength = 40;

					if(strlen($src) > $maxlength)
						$title = substr($src, 0, $maxlength-3).'...';
					else $title = $src;

					return $title;
				}

				$args = array('parent' => $pageObj->ID, 'sort_order' => 'asc', 'sort_column' => 'menu_order');
				$nav = get_pages($args);
				$content = array();
				foreach($nav as $navItem) {
					$contentSection = '';

					$subnav = get_pages(array('parent' => $navItem->ID, 'sort_order' => 'asc', 'sort_column' => 'menu_order'));
					if(sizeof($subnav) > 0) {
						$contentSub = array();
						
						$contentSub[] = $navItem->ID.'||'.$navItem->post_title;
						foreach($subnav as $subnavItem) {
							$contentSub[] = $subnavItem->ID.'||'.$subnavItem->post_title;
						}
						$content[] = $contentSub;
					} else {
						$content[] = $navItem->ID.'||'.$navItem->post_title;
					}
				}

				//output blocks
				if(gettype($content[0]) != 'array')
					echo '<div class="section-links">';

				for($c=0; $c<sizeof($content); $c++) {
					$entry = $content[$c];

					if(gettype($entry) == 'array') {
						$header = explode('||', $entry[0]);
						echo '<h2>'.$header[1].'</h2>';
						echo '<div class="section-links">';

						for($d=1; $d<sizeof($entry); $d++) {
							$entryArray = explode('||', $entry[$d]);
							echo '<div class="section-link">';
							echo '<a href="'.get_permalink($entryArray[0]).'" title="'.$entryArray[1].'"><span>';
							echo output_title($entryArray[1]).'</span></a>';
							echo '</div>';
						}
						echo '</div>';
					} else {
						if(gettype($content[$c-1]) == 'array')
							echo '<div class="section-links">';
						$entryArray = explode('||', $entry);
						echo '<div class="section-link">';
						echo '<a href="'.get_permalink($entryArray[0]).'" title="'.$entryArray[1].'"><span>';
						echo output_title($entryArray[1]).'</span></a>';
						echo '</div>';
						if(gettype($content[$c+1]) == 'array' || sizeof($content) <= $c+1)
							echo '</div>';
					}
				}
			?>
		</article>

		<section class="col-right">
		<?php
			echo '<div class="hide-mobile">'.apply_filters('the_content', $pageObj->post_content).'</div>';
		?>

			<h2>Get in touch</h2>
			<p>Call us on 1300 555 666 or use the form below to get in touch about <?php echo $pageObj->post_title; ?> services.</p>
			<?php echo do_shortcode('[contact-form-7 id="232" title="Get in touch (Sections)"]'); ?>
		</section>
	</div>

	<?php get_footer(); ?> 