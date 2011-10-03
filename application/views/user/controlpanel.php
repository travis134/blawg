<?php
$output = '<h1>Welcome, '.$user->get('username').'!</h1>';
$output .= View::factory('user/read')
	->set('user', $user);
echo $output;
?>