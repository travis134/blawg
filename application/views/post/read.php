<?php
$output = '<article class="post">';
$output .= '<header class="post-title"><h1 class="post-title-text">'.$post->get('title').'</h1></header>';
$output .= '<section class="post-content"><p class="post-content-text">'.$post->get('content').'</p></section>';
$output .= '</article>';
echo $output;
?>