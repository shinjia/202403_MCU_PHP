<?php
$min = 1;  
$max = 12;
$total = 6;  // 球的個數


$str = '';  // 全部圖的語法
$check = '';
$a_box = array();  // 宣告陣列
for($i=1; $i<=$total; $i++) {
    do {
        $num = mt_rand($min, $max);  // 產生球
        $check .= $num . ', ';

        // 檢查球有沒有在盒子裡
        $found = false;
        foreach($a_box as $one) {
            if($one==$num) {
                $found = true;
            }
        }
    } while( $found );
    $a_box[] = $num;  // 放入盒子內
}

echo '<pre>';
print_r($a_box);
echo '</pre>';

// 排序 (由小排到大)
sort($a_box);

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
  <p>check: {$check}</p>
  <p>{$str}</p>
    
</body>
</html>
HEREDOC;

echo $html;
?>