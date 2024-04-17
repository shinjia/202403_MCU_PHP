<?php
include '../common/config.php';
include '../common/define.php';
include '../common/utility.php';

// 接收傳入變數
$uid  = $_POST['uid']  ?? '';
$page = $_POST['page'] ??  1;   // 目前的頁碼
$nump = $_POST['nump'] ?? 10;   // 每頁的筆數

$workcode = $_POST['workcode'] ?? '';
$workname = $_POST['workname'] ?? '';
$intro  = $_POST['intro']  ?? '';
$descr = $_POST['descr'] ?? '';
$pub_date   = $_POST['pub_date']   ?? 0;
$picture   = $_POST['picture']   ?? 0;
$remark   = $_POST['remark']   ?? '';

// 連接資料庫
$pdo = db_open();

// SQL 語法
$sqlstr = "UPDATE work SET 
   workcode=:workcode, 
   workname=:workname, 
   intro=:intro, 
   descr=:descr, 
   pub_date=:pub_date, 
   picture=:picture, 
   remark=:remark 
WHERE uid=:uid ";

$sth = $pdo->prepare($sqlstr);
$sth->bindParam(':workcode', $workcode, PDO::PARAM_STR);
$sth->bindParam(':workname', $workname, PDO::PARAM_STR);
$sth->bindParam(':intro' , $intro , PDO::PARAM_STR);
$sth->bindParam(':descr', $descr, PDO::PARAM_STR);
$sth->bindParam(':pub_date'  , $pub_date  , PDO::PARAM_INT);
$sth->bindParam(':picture'  , $picture  , PDO::PARAM_INT);
$sth->bindParam(':remark'  , $remark  , PDO::PARAM_STR);
$sth->bindParam(':uid'     , $uid     , PDO::PARAM_INT);

// 執行 SQL
try { 
   $sth->execute();

   $lnk_display = "display.php?uid=" . $uid . '&page=' . $page . '&nump=' . $nump;
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