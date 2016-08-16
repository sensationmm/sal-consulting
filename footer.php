<?php global $variablesArray, $navigationContainer; ?>
    <footer>
		<div class="body">

			<div class="info">
				<div class="logo">
					<a href="/" title="Go to Homepage"><img src="assets/images/sal-consulting-logo.gif" /></a>
				</div>

				<div class="tel">Ph: <a href="tel://<?php echo str_replace(' ','',$variablesArray['telephone']); ?>"><?php echo $variablesArray['telephone']; ?></a></div>

				<ul class="social">
				<li><a href="mailto:<?php echo $variablesArray['email-address']; ?>" title="Email Us" target="_blank">
					<img src="assets/images/icon-email.png" rel="assets/images/icon-email-hover.png" /></a></li>
				<li><a href="<?php echo $variablesArray['facebook']; ?>" target="_blank" title="Follow us on Facebook" target="_blank">
					<img src="assets/images/icon-facebook.png" rel="assets/images/icon-facebook-hover.png" /></a></li>
				</ul>
			</div>
			<ul>
			<li class="header">Our Services</li>
			<?php
    			$services = wp_get_nav_menu_items('footer-services');
    			if(sizeof($services) > 0) {
    				for($i=0; $i<sizeof($services); $i++) {
    					$navPage = get_field('_menu_item_object_id', $services[$i]->ID);
    					$navPage = get_post($navPage);

    					$label = ($services[$i]->post_title != '') ? $services[$i]->post_title : $navPage->post_title;

    					echo '<li><a href="'.get_permalink($navPage->ID).'" title="'.$label.'">'.$label.'</a></li>';
    				}
    			}
    		?>
			</ul>

			<ul class="twocol">
			<li class="header">Additional information</li>
			<li>
				<ul>
				<?php
	    			$info1 = wp_get_nav_menu_items('footer-info-1');
	    			if(sizeof($info1) > 0) {
	    				for($i=0; $i<sizeof($info1); $i++) {
	    					$navPage = get_field('_menu_item_object_id', $info1[$i]->ID);
	    					$navPage = get_post($navPage);

	    					$label = ($info1[$i]->post_title != '') ? $info1[$i]->post_title : $navPage->post_title;

	    					echo '<li><a href="'.get_permalink($navPage->ID).'" title="'.$label.'">'.$label.'</a></li>';
	    				}
	    			}
	    		?>
				</ul>
			</li>
			<li>
				<ul>
				<?php
	    			$info2 = wp_get_nav_menu_items('footer-info-2');
	    			if(sizeof($info2) > 0) {
	    				for($i=0; $i<sizeof($info2); $i++) {
	    					$navPage = get_field('_menu_item_object_id', $info2[$i]->ID);
	    					$navPage = get_post($navPage);

	    					$label = ($info2[$i]->post_title != '') ? $info2[$i]->post_title : $navPage->post_title;

	    					echo '<li><a href="'.get_permalink($navPage->ID).'" title="'.$label.'">'.$label.'</a></li>';
	    				}
	    			}
	    		?>
				</ul>
			</li>
			</ul>
		</div>
	</footer>

	<?php echo $navigationContainer; ?>
	
	<script src="assets/js/app.min.js"></script>

	<?php wp_footer(); ?>
</body>
</html>