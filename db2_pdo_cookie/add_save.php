<?php
include 'config.php';
include 'utility.php';

// 接收傳入變數
$usercode = $_POST['usercode'] ?? '';
$username = $_POST['username'] ?? '';
$address  = $_POST['address']  ?? '';
$birthday = $_POST['birthday'] ?? '';
$height   = $_POST['height']   ?? '';
$weight   = $_POST['weight']   ?? '';
$remark   = $_POST['remark']   ?? '';

// 連接資料庫
$pdo = db_open();

// SQL 語法
$sqlstr = "INSERT INTO person(usercode, username, address, birthday, height, weight, remark) VALUES (:usercode, :username, :address, :birthday, :height, :weight, :remark)";

$sth = $pdo->prepare($sqlstr);
$sth->bindParam(':usercode', $usercode, PDO::PARAM_STR);
$sth->bindParam(':username', $username, PDO::PARAM_STR);
$sth->bindParam(':address' , $address , PDO::PARAM_STR);
$sth->bindParam(':birthday', $birthday, PDO::PARAM_STR);
$sth->bindParam(':height'  , $height  , PDO::PARAM_INT);
$sth->bindParam(':weight'  , $weight  , PDO::PARAM_INT);
$sth->bindParam(':remark'  , $remark  , PDO::PARAM_STR);

// 執行 SQL
try { 
   $sth->execute();

   $new_uid = $pdo->lastInsertId();    // 傳回剛才新增記錄的 auto_increment 的欄位值
   
   // 寫入 cookie
   setcookie('page', 99999, time()+86400*7);
   setcookie('uid', $new_uid, time()+86400*7);

   $lnk_display = "display.php?uid=" . $new_uid;
   header('Location: ' . $lnk_display);
}
catch(PDOException $e) {
   $ihc_error = error_message('ERROR_QUERY', $e->getMessage());
   
   $html = <<< HEREDOC
   {$ihc_error}
HEREDOC;
   include 'pagemake.php';
   pagemake($html);
}

db_close();

?>