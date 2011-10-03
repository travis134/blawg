<?php
$output = '<h1>Blawg</h1>';
$output .= '<p><a href="/blawg/login">Log in</a></p>';
$output .= '<p><a href="/blawg/logout">Log out</a></p>';
$output .= View::factory('post/read_all')
	->set('posts', $posts);
echo $output;
?>