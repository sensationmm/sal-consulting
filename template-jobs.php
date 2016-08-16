<?php
/**
 * @package WordPress
 * @subpackage SAL Consulting 2015
 * Template Name: Jobs
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

				$jobs = get_posts(array('post_type' => 'job'));
				$count = 0;
				foreach($jobs as $job) {
					echo '<div class="job">';
					echo '<h3>'.$job->post_title.'</h3>';
					$date = date('j F Y', strtotime(get_field('job_closing', $job->ID)));
					echo '<div class="job-closing">Applications close '.$date.'</div>';
					echo apply_filters('the_content', $job->post_content);
					echo '<p style="margin-top:35px;"><strong>Click on the button below to submit your application including your CV.</strong></p>';
					echo '<a class="button arrow" href="'.get_permalink($job->ID).'" title="Apply for '.$job->post_title.'">Apply</a>';
					echo '</div>';
				}
			?>
			</div>
		</article>
	</div>

<?php get_footer(); ?> 