<?php

// echo '<pre>';
// print_r($_POST);
// echo '</pre>';
$restcode = $_POST['restcode'] ?? '';

$price_auto = $_POST['price_auto'] ?? 0;
$price_user = $_POST['price_user'] ?? 0;
$membcode = $_POST['membcode'] ?? '';
$membname = $_POST['membname'] ?? '無名氏';
$a_amt = $_POST['amt'] ?? [];
$a_note = $_POST['note'] ?? [];

$data = '<ul>';
foreach($a_amt as $key=>$value) {
    // 只顯示有數量的
    if($value!=0) {
        $data .= '<li>';
        $data .= '項目 (' . $key . ') ';
        $data .= '===> 數量(' . $value . ') ';
        $data .= '===> 附註(' . $a_note[$key] . ')';
        $data .= '</li>';
    }
}
$data .= '</ul>';
$data .= '總金額(自動計算)：' . $price_auto;
$data .= '<br>';
$data .= '總金額(用戶輸入)：' . $price_user;

// 將此資料寫入指定的檔案內
// 宜做成 CSV 試算表格式，以便合併計算

// 要寫入的檔案
$file_rec = '__rec_' . $restcode . '.txt';

// 記錄表頭 (只有在第一次時)
if(!file_exists($file_rec)) {
    $rec = '';
    $rec .= '代碼,';
    $rec .= '姓名,';
    $rec .= '金額(試算),';
    $rec .= '金額(輸入),';
    $i = 0;
    foreach($a_amt as $key=>$value) {
        // 全部欄位都要記錄
        $i++;
        $rec .= '項目' . $i . ',';
        $rec .= '數量' . $i . ',';
        $rec .= '附註' . $i . ',';
    }
    $rec .= '時間';
    $rec .= "\n";
    file_put_contents($file_rec, $rec, FILE_APPEND);
}

// 記錄內容
$rec = '';
$rec .= $membcode . ',';
$rec .= $membname . ',';
$rec .= $price_auto . ',';
$rec .= $price_user . ',';
foreach($a_amt as $key=>$value) {
    // 全部欄位都要記錄，寫入CSV的要避免出現逗號
    $rec .= $key . ',';  // 項目
    $rec .= $value . ',';  // 數量
    $rec .= str_replace(',', '，', $a_note[$key]) . ',';  // 附註
}
$rec .= date('Y-m-d H:i:s', time());  // 時間
$rec .= "\n";

// 寫入檔案
file_put_contents($file_rec, $rec, FILE_APPEND);

$html = <<< HEREDOC
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ding Test</title>
</head>
<body>
    <h2>訂餐系統主要操作頁面測試</h2>
    <h3>顯示訂購人的資訊</h3>
    <div>[{$membcode}] {$membname}</div>
    <h3>顯示菜單的訂購資訊</h3>
    <div>
    {$data}
    </div>

    <hr>
    <p>
    ※ 應將此資料寫入指定的檔案內<br>
    ※ 宜做成 CSV 試算表格式，以便合併計算
    </p>
</body>
</html>
HEREDOC;

echo $html;
?>