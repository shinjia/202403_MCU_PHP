<?php

$name = '陳信嘉';  // 名字
$birth = '1987-04-01';     // 出生
$photo = 'images/head1.jpg';  // 照片

/*
$name = '阮經天';  // 名字
$birth = '1982-8-7';     // 出生年
$photo = 'images/head2.jpg';  // 照片
*/

$age = date('Y', time()) - date('Y', strtotime($birth)) + 1;  // 年齡計算


// 幸運數字
$num = mt_rand(0, 9);

// $pic = 'images/$num.png';   // 單引號
// $pic = "images/$num.png";   // 雙引號會把變數置換掉
$pic = 'images/' . $num . '.png';  // 字串合併


// 顯示網頁
$html = <<< HEREDOC
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>個人資料</h1>
    <p>姓名：{$name}</p>
    <p>年齡：{$age}</p>
    <p><img src="{$photo}"></p>
    <p>幸運數字是 {$num} <img src="{$pic}"></p>
</body>
</html>
HEREDOC;

echo $html;
?>