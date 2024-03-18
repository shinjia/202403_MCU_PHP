<?php
$min = 1;  
$max = 49;
$total = 6;  // 球的個數


$str = '';  // 全部圖的語法
for($i=1; $i<=$total; $i++) {
    $num = mt_rand($min, $max);
    $str .= '<img src="images/' . $num . '.jpg">';
}


$html = <<< HEREDOC
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    {$str}
    
</body>
</html>
HEREDOC;

echo $html;
?>