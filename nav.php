<?php
	
	$path = $_SERVER['DOCUMENT_ROOT'];
	include_once $path . '/wp-blog-header.php';

	$parent = $_POST['nav_id'];
	if(!is_numeric($parent))
		die;

	$args = array('parent' => $parent, 'sort_order' => 'asc', 'sort_column' => 'menu_order');
	$nav = get_pages($args);
	$navigation = '';
	$navigation .= '<ul><li><ul>';
	$count = 0;
	foreach($nav as $navItem) {

		$count++;

		$subnav = get_pages(array('parent' => $navItem->ID, 'sort_order' => 'asc', 'sort_column' => 'menu_order'));
		if(sizeof($subnav) > 0) {
			
			if(substr($navigation, -5) == '</li>')
				$navigation .= '</ul><ul>';
			else if(substr($navigation, -4) != '<ul>')
				$navigation .= '<ul>';
			$navigation .= '<li class="header">'.$navItem->post_title.'</li>';

			foreach($subnav as $subnavItem) {
				$navigation .= '<li><a href="'.get_permalink($subnavItem->ID).'">'.$subnavItem->post_title.'</a></li>';
			}
			$navigation .= '</ul>';
		} else {
			if(substr($navigation, -5) != '</li>' && substr($navigation, -4) != '<ul>')
				$navigation .= '<ul>';
			$navigation .= '<li><a href="'.get_permalink($navItem->ID).'">'.$navItem->post_title.'</a></li>';

			/* balance columns */
			$colHeight = ceil(sizeof($nav) / 3);
			$colHeight = ($colHeight >= 6) ? $colHeight : 6;
			if($count == $colHeight) {
				$navigation .= '</ul></li><li><ul>';
				$count = 0;
			}
		}
	}
	$navigation .= '</li></ul>';
	
	if($navigation != '<ul>')
		$navigation = '<div class="body">'.$navigation.'</div>';
	else
		$navigation = '';

	echo $navigation;

?>