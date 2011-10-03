<?php
$output = '<article class="user">';
$output .= '<header class="user-username"><h2 class="user-username-text">'.$user->get('username').'</h2></header>';
$output .= '<section class="user-email_address"><p class="user-email_address-text"><a href="mailto:'.$user->get('email_address').'">Send Email</a></p></section>';
$output .= View::factory('post/read_all')
	->set('posts', Model_Post::readAllByUser($user->get('id'), 10, 0));
$output .= '</article>';
echo $output;
?>