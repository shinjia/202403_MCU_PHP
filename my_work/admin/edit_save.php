<?php
session_start();

include '../common/config.php';
include '../common/define.php';
include '../common/utility.php';

$ss_usertype = $_SESSION[DEF_SESSION_USERTYPE] ?? '';
$ss_usercode = $_SESSION[DEF_SESSION_USERCODE] ?? '';

if($ss_usertype!=DEF_LOGIN_ADMIN) {
    header('Location: login_error.php');
    exit;
}

//======= 以上為權限控管檢查 ==========================


// 接收傳入變數
$uid  = $_POST['uid']  ?? '';
$page = $_POST['page'] ??  1;   // 目前的頁碼
$nump = $_POST['nump'] ?? 10;   // 每頁的筆數

$workcode = $_POST['workcode'] ?? '';
$workname = $_POST['workname'] ?? '';
$intro    = $_POST['intro']    ?? '';
$descr    = $_POST['descr']    ?? '';
$pub_date = $_POST['pub_date'] ?? '';
$picture  = $_POST['picture']  ?? '';
$tags     = $_POST['tags']     ?? '';
$category = $_POST['category'] ?? '';
$score    = $_POST['score']    ?? '';
$is_open  = $_POST['is_open']  ?? '';
$remark   = $_POST['remark']   ?? '';

// 注意：處理 is_open 的值
$is_open = ($is_open=='Y') ? 1 : 0;

// 連接資料庫
$pdo = db_open();

// SQL 語法
$sqlstr = "UPDATE work SET 
   workcode=:workcode, 
   workname=:workname, 
   intro   =:intro, 
   descr   =:descr, 
   pub_date=:pub_date, 
   picture =:picture, 
   tags    =:tags,
   category=:category,
   score   =:score,
   is_open =:is_open,
   remark  =:remark 
WHERE uid=:uid ";

$sth = $pdo->prepare($sqlstr);
$sth->bindParam(':workcode', $workcode, PDO::PARAM_STR);
$sth->bindParam(':workname', $workname, PDO::PARAM_STR);
$sth->bindParam(':intro'   , $intro   , PDO::PARAM_STR);
$sth->bindParam(':descr'   , $descr   , PDO::PARAM_STR);
$sth->bindParam(':pub_date', $pub_date, PDO::PARAM_STR);
$sth->bindParam(':picture' , $picture , PDO::PARAM_STR);
$sth->bindParam(':tags'    , $tags    , PDO::PARAM_STR);
$sth->bindParam(':category', $category, PDO::PARAM_STR);
$sth->bindParam(':score'   , $score   , PDO::PARAM_INT);
$sth->bindParam(':is_open' , $is_open , PDO::PARAM_INT);
$sth->bindParam(':remark'  , $remark  , PDO::PARAM_STR);
$sth->bindParam(':uid'     , $uid     , PDO::PARAM_INT);

// 執行 SQL
try { 
   $sth->execute();

   $lnk_display = "display.php?uid=" . $uid . '&page=' . $page . '&nump=' . $nump;
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