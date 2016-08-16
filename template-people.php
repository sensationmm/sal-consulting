<?php
/**
 * @package WordPress
 * @subpackage SAL Consulting 2015
 * Template Name: People
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
			<div>
			<?php 
				if($pageObj->post_content != '')
					echo apply_filters('the_content', $pageObj->post_content); 

				$people = get_posts(array('post_type' => 'people'));
				$count = 0;
				foreach($people as $person) {
					$image = get_field('people_photo', $person->ID);
					if(get_field('people_image', $person->ID) != '')
						$banner = get_field('people_image', $person->ID);

					$text = '<b>Qualifications / Professional Associations:</b>';
					$text .= apply_filters('the_content', get_field('people_qualifications', $person->ID));
					$text .= '<b>Summary Professional Experience:</b>';
					$text .= apply_filters('the_content', get_field('people_experience', $person->ID));

					echo '<div class="person" id="person'.$person->ID.'">';
						echo '<div class="person-image"><img src="'.$image.'" alt="'.$person->post_title.'" /></div>';
						echo '<div class="person-name">'.$person->post_title.'</div>';
						echo '<div class="person-title">'.get_field('people_title', $person->ID).'</div>';
						echo '<div class="person-hidden person-banner">'.$banner.'</div>';
						echo '<div class="person-hidden person-text">'.$text.'</div>';
						$nextID = ($count+1 < sizeof($people)) ? $count+1 : 0;
						$prevID = ($count-1 >= 0) ? $count-1 : sizeof($people)-1;
						echo '<div class="person-hidden person-next">'.$people[$nextID]->ID.'</div>';
						echo '<div class="person-hidden person-prev">'.$people[$prevID]->ID.'</div>';
					echo '</div>';

					$count++;


					//$image = get_field('people_photo', $person->ID); echo '<div class="person">'; echo '<div class="person-image"><img src="'.$image.'" alt="'.$person->post_title.'" /></div>'; echo '<div class="person-name">'.$person->post_title.'</div>'; echo '<div class="person-title">'.get_field('people_title', $person->ID).'</div>'; echo '</div>'; $image = get_field('people_photo', $person->ID); echo '<div class="person">'; echo '<div class="person-image"><img src="'.$image.'" alt="'.$person->post_title.'" /></div>'; echo '<div class="person-name">'.$person->post_title.'</div>'; echo '<div class="person-title">'.get_field('people_title', $person->ID).'</div>'; echo '</div>'; 
				}
			?>
			</div>
		</article>
	</div>

	<div class="overlay">
		<div class="overlay-image"></div>
		<div class="overlay-next">c</div>
		<div class="overlay-prev">o</div>
		<div class="overlay-content"></div>
		<div class="overlay-close">d</div>
	</div>
	<div class="mask"></div>

<?php get_footer(); ?> 