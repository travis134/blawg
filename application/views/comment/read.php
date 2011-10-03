<?php
$output = '<article class="comment">';
$output .= '<header class="comment-author"><h3 class="comment-author-text"><a href="/blawg/user/'.$user->get('id').'">'.$user->get('username').'</a></h3></header>';
$output .= '<section class="comment-content"><p class="comment-content-text">'.$comment->get('content').'</p></section>';
$output .= '<section class="comment-info">';
$output .= '<p class="comment-datetime-text">'.$comment->get('date_time').'</p>';
$output .= '</section>';
$output .= '</article>';
echo $output;
?>