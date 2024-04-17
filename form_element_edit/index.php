<?php

$html = <<< HEREDOC
<h2>Hello</h2>
<p>請操作上述功能查看！</p>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>