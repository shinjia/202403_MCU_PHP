<?php
$height = $_POST['height'] ?? '';
$weight = $_POST['weight'] ?? '';

// 計算 BMI
$bmi = ($weight) / (($height/100)*($height/100));
// $bmi = $weight / pow($height/100, 2);  // 平方
// echo $bmi;

// 取兩位小數
$bmi = round($bmi, 2);  // 法一：四捨五入
// $bmi = number_format($bmi, 2);  // 法二：數字格式(會四捨五入)
// $bmi = floor($bmi*100)/100;  // 法三：先乘100，去尾，再除100
// $bmi = sprintf('%.2f', $bmi);  // 法四：使用 sprintf() 函式


// 判斷
$msg = '';  // 顯示文字
$pic = '';  // 顯示圖片
$url = '';  // 網頁
if($bmi>=24) {
    $msg = '月巴月半';
    $pic = 'images/s1.jpg';
    $url = 'page1.html';
}
elseif(($bmi<24)&&($bmi>=22)) {
    $msg = '過重';
    $pic = 'images/s2.jpg';
    $url = 'page2.html';
}
elseif(($bmi<22)&&($bmi>=17.5)) {
    $msg = '標準';
    $pic = 'images/s3.jpg';
    $url = 'page3.html';
}
elseif($bmi<17.5) {
    $msg = '太輕';
    $pic = 'images/s4.jpg';
    $url = 'page4.html';
}
else {
    $msg = '程式一定有錯！';
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
    <h1>BMI</h1>
    <p>你的 BMI 值是：{$bmi}</p>
    <p>{$msg}</p>
    <p><img src="{$pic}"></p>
    <p><a href="{$url}">建議…</a></p>
    <iframe src="{$url}" style="width:400px; height:200px;"></iframe>
    <hr>
    <p>身高：{$height}</p>
    <p>體重：{$weight}</p>
</body>
</html>
HEREDOC;

echo $html;
?>