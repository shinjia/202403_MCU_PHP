<?php

$menulist = '
a1, 排骨便當, 150, 老闆推薦
a2, 雞腿便當, 160, 必吃
a3, 魚排便當, 180, 吃過就忘不了

b1, 熱咖啡, 60, 中杯
b2, 冰紅茶, 40, 中杯

';

// $a_menu = explode("\n", $menulist);

// 使用 PHP_EOL 處理當前環境的換行符
$a_menu = explode(PHP_EOL, $menulist);

echo '<p>原來的陣列</p>';
echo '<pre>';
print_r($a_menu);
echo '</pre>';


$a_menu = array_filter($a_menu);  // 移除空白列

echo '<p>清除空字串後的陣列</p>';
echo '<pre>';
print_r($a_menu);
echo '</pre>';


$data = '<form method="post" action="test2_run.php">';
$data .= '<table border="1">';
foreach($a_menu as $value) {
    $a_item = explode(',', $value);
    array_map('trim', $a_item);
    $f_code = $a_item[0];
    $f_name = $a_item[1];
    $f_price = $a_item[2];
    $f_note = $a_item[3];

    $data .= '<tr>';
    $data .= '<td>' . $f_code . '</td>';
    $data .= '<td>' . $f_name . '</td>';
    $data .= '<td>' . $f_price . '</td>';
    $data .= '<td>' . $f_note . '</td>';
    $data .= '<td><input type="checkbox" name="want[]" value="' . $f_code . '"></td>';
    $data .= '<td><input type="text" name="note[]" size="1"></td>';
    $data .= '</tr>';
}
$data .= '</table>';
$data .= '<input type="submit" value="送出">';
$data .= '</form>';

echo $data;
?>