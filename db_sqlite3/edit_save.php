<?php
include 'config.php';
include 'utility.php';

// 接受外部表單傳入之變數
$uid = $_POST["uid"] ?? '';  // 此欄位關連鍵

$usercode = $_POST['usercode'] ?? '';
$username = $_POST['username'] ?? '';
$address  = $_POST['address']  ?? '';
$birthday = $_POST['birthday'] ?? '';
$height   = $_POST['height']   ?? '';
$weight   = $_POST['weight']   ?? '';
$remark   = $_POST['remark']   ?? '';

// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
$sqlstr .= "UPDATE person SET uid='" . $uid . "', usercode='" . $usercode . "',username='" . $username . "', address='" . $address . "', birthday='" . $birthday . "', height='" . $height . "', weight='" . $weight . "', remark='" . $remark . "' WHERE uid= " . $uid ;

// 執行SQL及處理結果
$sth = $pdo->exec($sqlstr);
if($sth===FALSE) {
   header('Location: error.php');
   echo print_r($pdo->errorInfo()) . '<br />' . $sqlstr;  // 此列供開發時期偵錯用
}
else {
   $url_display = 'display.php?uid=' . $uid;
   header('Location: ' . $url_display);
}


$html = <<< HEREDOC
{$msg}
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>