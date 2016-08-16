			<ul>
			<?php
				$submenu = get_pages(array('parent' => $toplevelID, 'sort_column' => 'menu_order', 'order' => 'asc'));
				$highlight == false;
				$mobileDropdown = '<form class="mobile-dropdown" name="mobiledropdown" method="post" action="/wp-content/themes/salconsulting/mobile-redirect.php">';
				$mobileDropdown .= '<select name="destination" onchange="document.mobiledropdown.submit();">';
				foreach($submenu as $page) {

					if($pageObj->ID == 210 && $page->ID == 194)
						$highlight = true;
					echo '<li><a '.(($pageObj->ID == $page->ID || $highlight) ? 'class="active" ' : '').'href="'.get_permalink($page->ID).'">'.$page->post_title.'</a></li>';

					$mobileDropdown .= '<option value="'.get_permalink($page->ID).'" '.(($pageObj->ID == $page->ID || $highlight) ? 'selected="selected" ' : '').'>'.$page->post_title.'</option>';
				}
				$mobileDropdown .= '</select>';
        		$mobileDropdown .= '<input type="hidden" name="action" value="redirect" />';
				$mobileDropdown .= '</form>';
			?>
			</ul>
			<?php echo $mobileDropdown; ?>