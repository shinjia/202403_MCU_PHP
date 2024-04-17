<?php
include '../common/config.php';
include '../common/define.php';
include '../common/utility.php';

// 接收傳入變數
$page = $_POST['page'] ?? 10;
$nump = $_POST['nump'] ??  1;

$workcode = $_POST['workcode'] ?? '';
$workname = $_POST['workname'] ?? '';
$intro  = $_POST['intro']  ?? '';
$descr = $_POST['descr'] ?? '';
$pub_date   = $_POST['pub_date']   ?? '';
$picture   = $_POST['picture']   ?? '';
$remark   = $_POST['remark']   ?? '';

// 連接資料庫
$pdo = db_open();

// SQL 語法
$sqlstr = "INSERT INTO work(
   workcode,
   workname,
   intro,
   descr,
   pub_date,
   picture,
   remark)
   VALUES (
   :workcode,
   :workname,
   :intro,
   :descr,
   :pub_date,
   :picture,
   :remark)";

$sth = $pdo->prepare($sqlstr);
$sth->bindParam(':workcode', $workcode, PDO::PARAM_STR);
$sth->bindParam(':workname', $workname, PDO::PARAM_STR);
$sth->bindParam(':intro' , $intro , PDO::PARAM_STR);
$sth->bindParam(':descr', $descr, PDO::PARAM_STR);
$sth->bindParam(':pub_date'  , $pub_date  , PDO::PARAM_INT);
$sth->bindParam(':picture'  , $picture  , PDO::PARAM_INT);
$sth->bindParam(':remark'  , $remark  , PDO::PARAM_STR);

// 執行 SQL
try { 
   $sth->execute();

   $new_uid = $pdo->lastInsertId();    // 傳回剛才新增記錄的 auto_increment 的欄位值
   $lnk_display = "display.php?uid=" . $new_uid . '&nump=' . $nump . '&page=99999';
   header('Location: ' . $lnk_display);
}
catch(PDOException $e) {
   // db_error(ERROR_QUERY, $e->getMessage());
   $ihc_error = error_message('ERROR_QUERY', $e->getMessage());
   
   $html = <<< HEREDOC
   {$ihc_error}
HEREDOC;
   include 'pagemake.php';
   pagemake($html);
}

db_close();

?>