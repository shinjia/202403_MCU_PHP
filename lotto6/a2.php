<?php
$min = 1;  
$max = 12;
$total = 6;  // 球的個數


$str = '';  // 全部圖的語法
for($i=1; $i<=$total; $i++) {
    $num = mt_rand($min, $max);
    $a_box[] = $num;
}

echo '<pre>';
print_r($a_box);
echo '</pre>';

// 顯示出來
$str = '';
foreach($a_box as $one) {
    $str .= '<img src="images/' . $one . '.jpg">';
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