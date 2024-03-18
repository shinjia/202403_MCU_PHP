<?php
$min = 1;
$max = 42;
$total = 6;

// 全部的球放進盒子裡
$a_full = range($min, $max);
// 隨機挑出六個，注意傳回 key
$a_box = array_rand($a_full, $total);

// 畫面輸出
$str = '';
foreach($a_box as $one) {
    $str .= '<img src="images/' . $a_full[$one] . '.jpg"> ';
}

//echo '<pre>';
//print_r($a_box);
//echo '</pre>';
//exit;

$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Title of the document</title>
</head>
<body>
<h1>你的幸運數字</h1>
<p>{$str}</p>
<p><a href="?">再執行一次</a></p>
</body>
</html>
HEREDOC;

echo $html;
?>
