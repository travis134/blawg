<?php
$output = '<section id="posts">';
foreach($posts as $post)
{
	$output .= View::factory('post/read')
		->set('post', $post)
		->set('user', Model::factory('user')->set('id', $post->get('author_id'))->read());
}
$output .= '</section>';
echo $output;
?>
