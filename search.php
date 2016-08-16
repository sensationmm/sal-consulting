<?php
/**
 * @package WordPress
 * @subpackage SAL Consulting 2015
*/

get_header();  
?>

	<div class="strap">
		<div class="body">
			<h1 style="background-image:url(<?php echo $styleIcon; ?>);">Search results</h1>
		</div>
	</div>

	<div class="body">
		<article class="thanks">

			<form class="search" method="get" action="/">
			<input value="<?php echo $_GET["s"]; ?>" name="s" id="s" type="text" placeholder="Search our site">
			<input type="image" src="assets/images/icon-search.gif" />
			</form>

			<?php
				$s = get_search_query();
				$pageExclusions = array(229,238,210);
				$args = array('s' => $s);
				// The Query
				$the_query = new WP_Query( $args );
				if ( $the_query->have_posts() ) {
					echo '<ul>';
			        while ( $the_query->have_posts() ) {
			           $the_query->the_post();
			           	if(!in_array(get_the_ID(), $pageExclusions )) {
		                 ?>
		                    <li>
		                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		                        <?php
		                        	$content = get_the_content();
									$content = strip_tags($content);
									if(strlen($content) > 200)
										$content = substr($content, 0, 200).' [...]';
									echo '<p>'.$content.'</p>';
									$pageExclusions[] = get_the_ID();
		                        ?>
		                    </li>
		                 <?php
		             }
			        }
					echo '</ul>';



					echo do_shortcode('[ajax_load_more repeater="default" posts_per_page="2" transition="fade" button_label="Load More Results" scroll="false" pause="true" post__not_in="'.implode($pageExclusions, ',').'" search="'.$_GET["s"].'"]');
			    } else {
			?>
		        <h2>Nothing Found</h2>
		        <div class="alert alert-info">
		        	<p>Sorry, but nothing matched your search criteria. Please try again with some different keywords.</p>
		        </div>
		<?php } ?>
		</article>
	</div>

	<?php get_footer(); ?> 