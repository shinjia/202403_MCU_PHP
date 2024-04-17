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

$restcode = $_POST['restcode'] ?? '';
$restname = $_POST['restname'] ?? '';
$address  = $_POST['address']  ?? '';
$time     = $_POST['time']     ?? '';
$tel      = $_POST['tel']      ?? '';
$intro    = $_POST['intro']    ?? '';
$descr    = $_POST['descr']    ?? '';
$resttype = $_POST['resttype'] ?? '';
$google   = $_POST['google']   ?? '';
$menulist = $_POST['menulist'] ?? '';
$remark   = $_POST['remark']   ?? '';

// 連接資料庫
$pdo = db_open();

// SQL 語法
$sqlstr = "UPDATE rest SET 
   restcode=:restcode, 
   restname=:restname, 
   address=:address,
   time=:time,
   tel=:tel,
   intro=:intro,
   descr=:descr,
   resttype=:resttype, 
   google=:google, 
   menulist=:menulist, 
   remark=:remark 
WHERE uid=:uid ";

$sth = $pdo->prepare($sqlstr);
$sth->bindParam(':restcode', $restcode, PDO::PARAM_STR);
$sth->bindParam(':restname', $restname, PDO::PARAM_STR);
$sth->bindParam(':address' , $address , PDO::PARAM_STR);
$sth->bindParam(':time'    , $time    , PDO::PARAM_STR);
$sth->bindParam(':tel'     , $tel     , PDO::PARAM_STR);
$sth->bindParam(':intro'   , $intro   , PDO::PARAM_STR);
$sth->bindParam(':descr'   , $descr   , PDO::PARAM_STR);
$sth->bindParam(':resttype', $resttype, PDO::PARAM_STR);
$sth->bindParam(':google'  , $google  , PDO::PARAM_INT);
$sth->bindParam(':menulist', $menulist, PDO::PARAM_STR);
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