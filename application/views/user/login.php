<?php
$output = '<h1>Log in</h1>';
$output .= '<form name="login-form" action="/blawg/login" method="POST">';
$output .= 'Username: <input type="text" size=20 name="login-username">';
$output .= 'Password: <input type="password" name="login-password">';
$output .= '<input type="submit" value="Login"/>';
echo $output;
?>