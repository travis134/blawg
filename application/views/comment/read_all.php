<?php
$output = '<section class="comments">';
foreach($comments as $comment)
{
	$output .= View::factory('comment/read')
		->set('comment', $comment)
		->set('user', Model::factory('user')->set('id', $comment->get('author_id'))->read());
}
$output .= '</section>';
echo $output;
?>
