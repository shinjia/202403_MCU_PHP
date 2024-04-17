<?php
function add($s) {
    return ('『' . trim($s) . '』');
}

// part1 : 字串轉陣列
$str = '唱歌   ,   看書, 運動, 美食';
$delim = ',';  // 分隔字元

$ary = explode($delim, $str);

echo '<h2>原來陣列內容</h2>';
echo '<pre>';
print_r($ary);
echo '</pre>';

// 方法一
$ary_ok = array();
foreach($ary as $value) {
    $ary_ok[] = trim($value);
}
echo '<h2>移除空白後的陣列</h2>';
echo '<pre>';
print_r($ary_ok);
echo '</pre>';

// 方法二
// $ary_ok2 = array_map('trim', $ary);
$ary_ok2 = array_map('add', $ary);
echo '<h2>移除空白後的陣列 (使用 array_map())</h2>';
echo '<pre>';
print_r($ary_ok2);
echo '</pre>';


// 增加項目
$ary_ok2[] = '『美食』';
array_push($ary_ok2, '『電影』');


// part2 : 陣列轉字串
echo '<h2>陣列轉字串</h2>';
$str_new = implode('、', $ary_ok2);
echo $str_new; 

?>
