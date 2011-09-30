<?php
$output = '<section id="posts">';
foreach($posts as $post)
{
	$output .= View::factory('post/read')
		->set('post', $post);
}
$output .= '</section>';
echo $output;
?>
