<?php
	if($post->post_type == 'post')
		include 'single-blog.php';
	else if($post->post_type == 'job')
		include 'single-job.php';
	else if($post->post_type == 'event')
		include 'single-event.php';
	else
		header('Location: /not-found/');
?>