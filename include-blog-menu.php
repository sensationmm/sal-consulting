			<?php
				$blogPage = get_page(158);
			?>
			<form class="search" action="<?php echo get_permalink($blogPage->ID); ?>" method="get">
			<input name="keywords" type="text" placeholder="Search our articles" value="<?php echo $_GET["keywords"]; ?>" />
			<input type="image" src="assets/images/icon-search.gif" />
			</form>
			
			<?php
				//Recent articles
				$recent = get_posts(array('posts_per_page' => 5));
				echo '<h2 class="widget_title">Recent articles</h2>';
				echo '<ul class="widget">';
				foreach($recent as $article) {
					echo '<li><a '.(($article->ID == $pageObj->ID) ? 'class="active"' : '').' href="'.get_permalink($article->ID).'" title="Read '.$article->post_title.'">'.$article->post_title.'</a></li>';
				}
				echo '</ul>';

				//Popular articles
				echo '<h2 class="widget_title">Popular articles</h2>';
				echo do_shortcode('[wpp range="weekly" post_type="post" limit=5 stats_views=0 order_by="views"]');
			?>