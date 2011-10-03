<?php
$output = '<article class="post">';
$output .= '<header class="post-title"><h2 class="post-title-text"><a href="/blawg/post/'.$post->get('id').'">'.$post->get('title').'</a></h2></header>';
$output .= '<section class="post-content"><p class="post-content-text">'.$post->get('content').'</p></section>';
$output .= '<section class="post-info">';
$output .= '<p class="post-author-text"><a href="/blawg/user/'.$user->get('id').'">'.$user->get('username').'</a></p>';
$output .= '<p class="post-datetime-text">'.$post->get('date_time').'</p>';
$output .= View::factory('comment/read_all')
	->set('comments', Model_Comment::readAll($post->get('id'), 10, 0));
$output .= '</section>';
$output .= '</article>';
echo $output;
?>