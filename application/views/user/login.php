<?php
$output = '<form name="login-form" action="login.php" method="POST">';
$output .= 'Username: <input type="text" size=20 name="login-username">';
$output .= 'Password: <input type="password" name="login-password">';
$output .= '<input type="submit" value="Login"/>';
echo $output;
?>