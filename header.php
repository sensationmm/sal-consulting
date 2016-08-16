<?php
	global $headerInclude, $post, $pageObj, $template, $style, $styleIcon, $variables, $variablesArray, $toplevel, $toplevelID, $navigationContainer;
	global $parent, $grandparent, $greatgrandparent; //for breadcrumb
	$pageObj = $post;
	$template = get_current_template();
	$template = str_replace('template-', '', $template);
	$template = substr($template, 0, stripos($template, '.'));

	if($pageObj->ID != 8)
		$pageTitle = $pageObj->post_title.' :: ';
	else 
		$pageTitle = '';

	//Site variables
	$variables = get_posts(array('post_type' => 'variable'));
	$variablesArray = array();
	for($v=0; $v<sizeof($variables); $v++) {
		$variablesArray[$variables[$v]->post_name] = get_field('variable_value', $variables[$v]->ID);
	}

	// Get section
	$parentID = $pageObj->post_parent;
	$parent = get_page($parentID);
	if($parent->post_parent == 0) {
		$toplevel = $parent->post_title;
		$toplevelID = $parent->ID;

		if(strtolower($toplevel) == 'more') {
			$toplevel = $pageObj->post_title;
			$toplevelID = $pageObj->ID;
		}
	} else {
		$grandparentID = $parent->post_parent;
		$grandparent = get_page($grandparentID);
		if($grandparent->post_parent == 0) {
			$toplevel = $grandparent->post_title;
			$toplevelID = $grandparent->ID;

			if(strtolower($toplevel) == 'more') {
				$toplevel = $parent->post_title;
				$toplevelID = $parent->ID;
			}
		} else {
			$greatgrandparentID = $grandparent->post_parent;
			$greatgrandparent = get_page($greatgrandparentID);
			if($greatgrandparent->post_parent == 0) {
				$toplevel = $greatgrandparent->post_title;
				$toplevelID = $greatgrandparent->ID;

				if(strtolower($toplevel) == 'more') {
					$toplevel = $grandparent->post_title;
					$toplevelID = $grandparent->ID;
				}
			} else {
				$toplevel = 'HIGHER';
				$toplevelID = 0;
			}
		}
	}

	//get page styles
	$style = get_section_style($toplevelID);
	$styleIcon = get_style_icon($toplevelID);
	//check for page level overrides
	$styleOverride = get_field('override_style', $pageObj->ID);
	if($styleOverride != '')
		$style = $styleOverride;
	$styleIconOverride = get_field('override_icon', $pageObj->ID);
	if($styleIconOverride != '')
		$styleIcon = $styleIconOverride;

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title><?php echo $pageTitle; ?>SAL Consulting</title>
<base href="/wp-content/themes/salconsulting/" /><!--[if IE]></base><![endif]-->
<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico" />
<link rel="stylesheet" href="assets/css/style.css" />
<!--[if IE]>
  <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link href='https://fonts.googleapis.com/css?family=Roboto:500,400,300,100,700,400italic' rel='stylesheet' type='text/css'>
<?php echo $headerInclude; ?>
<?php wp_head(); ?>
<script type="text/javascript">
<!--//--><![CDATA[//><!--
	var images = new Array()
	function preload() {
		for (i = 0; i < preload.arguments.length; i++) {
			images[i] = new Image()
			images[i].src = preload.arguments[i]
		}
	}
	preload("/wp-content/themes/salconsulting/assets/images/sal-consulting-logo.gif")
//--><!]]>
</script>
</head>
<body id="<?php echo $template; ?>" data-style="<?php echo $style; ?>">

	<header>
		<div class="body">
			<div class="logo">
				<a href="/home/" title="Go to Homepage"><img src="assets/images/sal-consulting-logo.gif" /></a>
			</div>

			<div class="mobile-phone">Ph: <a href="tel://<?php echo str_replace(' ','',$variablesArray['telephone']); ?>"><?php echo $variablesArray['telephone']; ?></a></div>

			<div class="info">

				<div class="parent-help-mobile"><a href="<?php echo get_permalink(26); ?>" title="Go to Parent help">Parent help</a></div>
				<div class="contact">Ph: <a href="tel://<?php echo str_replace(' ','',$variablesArray['telephone']); ?>"><?php echo $variablesArray['telephone']; ?></a> or&nbsp;&nbsp;<a class="email" href="mailto:<?php echo $variablesArray['email-address']; ?>">Email Us</a></div>
				<form class="search" method="get" action="/">
				<input value="<?php echo $_GET["s"]; ?>" name="s" id="s" type="text" placeholder="Search our site">
				<input type="image" src="assets/images/icon-search.gif" />
				</form>
			</div>

			<nav class="main">
			<?php
    			$nav = wp_get_nav_menu_items('header');
    			if(sizeof($nav) > 0) {
                    echo '<ul>';
					$navigationContainer = '';
    				for($i=0; $i<sizeof($nav); $i++) {
					$navigationHold = '';
    					$navPage = get_field('_menu_item_object_id', $nav[$i]->ID);
    					$navPage = get_post($navPage);

    					$pageExclusions = array(229,238,210);
    					//build subnav
    					$args = array('parent' => $navPage->ID, 'sort_order' => 'asc', 'sort_column' => 'menu_order', 'exclude' => $pageExclusions);
						$navSub = get_pages($args);
						$navigationHold .= '<ul>';
						$count = 0;
						foreach($navSub as $navItem) {

							$count++;

							$subnav = get_pages(array('parent' => $navItem->ID, 'sort_order' => 'asc', 'sort_column' => 'menu_order', 'exclude' => $pageExclusions));
							if(sizeof($subnav) > 0) {
								
								if(substr($navigationHold, -5) == '</li>')
									$navigationHold .= '</ul><ul>';
								else if(substr($navigationHold, -4) != '<ul>')
									$navigationHold .= '<ul>';
								$navigationHold .= '<li class="header" onclick="showHeaderNested(this);">'.$navItem->post_title.'</li>';

								foreach($subnav as $subnavItem) {
									$navigationHold .= '<li class="header-nested"><a href="'.get_permalink($subnavItem->ID).'">'.$subnavItem->post_title.'</a></li>';
								}
								$navigationHold .= '</ul>';
							} else {
								if(substr($navigationHold, -5) != '</li>' && substr($navigationHold, -4) != '<ul>')
									$navigationHold .= '<ul>';
								$navigationHold .= '<li><a href="'.get_permalink($navItem->ID).'">'.$navItem->post_title.'</a></li>';

								/* balance columns */
								$colHeight = ceil(sizeof($nav) / 3);
								$colHeight = ($colHeight > 7) ? $colHeight : 7;
								if($count == $colHeight) {
									$navigationHold .= '</ul><ul>';
									$count = 0;
								}
							}
						}
						
						if($navigationHold != '<ul>')
							$navigationHold = '<div class="hidden" id="subnav'.$navPage->ID.'"><div class="body" >'.$navigationHold.'</div></div>';
						else
							$navigationHold = '';

						$navigationContainer .= $navigationHold;
    					
    					echo '<li';
    					if(sizeof($navSub) > 0)
    						echo ' class="nested"';
    					echo '>';
    					echo '<a ';
    					if($pageObj->ID == $navPage->ID)
    						echo 'class="active" ';
    					echo 'href="'.get_permalink($navPage->ID).'" rel="'.$navPage->ID.'" title="Go to '.$navPage->post_title.'">'.$nav[$i]->title.'</a>';
    					echo '</li>';
	    			}
    				echo '</ul>';
	    		}
    		?>
			</nav>

			<div class="parent-help"><a href="<?php echo get_permalink(26); ?>" title="Go to Parent help">Parent help</a></div>

			<div class="mobile-nav">j</div>
		</div>
	</header>

	<div class="dropdown">
		<div class="body">
		</div>
	</div>