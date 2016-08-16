<?php
/**
 * @package WordPress
 * @subpackage SAL Consulting 2015
*/
get_header();  

//check for page level overrides
$styleOverride = get_field('override_style', 194);
if($styleOverride != '')
	$style = $styleOverride;
$styleIconOverride = get_field('override_icon', 194);
if($styleIconOverride != '')
	$styleIcon = $styleIconOverride;
?>
	<div class="strap">
		<div class="body">
		<?php $jobTitle = get_page(194); $parent = get_page($jobTitle->post_parent); ?>
			<h1 style="background-image:url(<?php echo $styleIcon; ?>);"><?php echo $parent->post_title; ?></h1>
		</div>
	</div>

	<div class="body">
		<nav class="col-left">
		<ul>
		<?php
			$submenu = get_pages(array('parent' => $jobTitle->post_parent, 'sort_column' => 'menu_order', 'sort_order' => 'asc'));
			foreach($submenu as $page) {
				echo '<li><a '.((194 == $page->ID && $pageObj->post_type == 'job') ? 'class="active" ' : '').'href="'.get_permalink($page->ID).'">'.$page->post_title.'</a></li>';
			}
		?>
		</ul>
		</nav>

		<article class="col-main">
			<h2><?php echo $jobTitle->post_title; ?></h2>
			<div>
			<?php 
				echo '<div class="job">';
				echo '<h3>'.$pageObj->post_title.'</h3>';
				echo '<p>To apply for the position of <strong>'.$pageObj->post_title.'</strong>, fill out the form below, upload your files and click on submit application.</p>';
				echo do_shortcode('[contact-form-7 id="209" title="Job Application" html_class="job_application"]');
				echo '</div>';
			?>
			</div>
		</article>
	</div>

	<script type="text/javascript">
	jQuery(document).ready(function(){

		//hide all inputs except the first one
		$('p.hide').not(':eq(0)').hide();

		//functionality for add-file link
		$('a.add_file').on('click', function(e){
			//show by click the first one from hidden inputs
			$('p.hide:not(:visible):first').show('slow');

			e.preventDefault();
		});

		//functionality for del-file link
		$('a.del_file').on('click', function(e){
			//var init
			var input_parent = $(this).parent();
			var input_wrap = input_parent.find('span');

			//reset field value
			input_wrap.html(input_wrap.html());

			//hide by click
			input_parent.hide('slow');

			e.preventDefault();
		});
	});
	</script>

<?php get_footer(); ?> 