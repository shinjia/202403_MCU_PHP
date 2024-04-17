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
$page = $_POST['page'] ?? 10;
$nump = $_POST['nump'] ??  1;

$restcode = $_POST['restcode'] ?? '';
$restname = $_POST['restname'] ?? '';
$address  = $_POST['address']  ?? '';
$time     = $_POST['time'] ?? '';
$tel      = $_POST['tel']   ?? '';
$intro    = $_POST['intro']   ?? '';
$descr    = $_POST['descr']   ?? '';
$resttype = $_POST['resttype']   ?? '';
$google   = $_POST['google']   ?? '';
$menulist = $_POST['menulist']   ?? '';
$remark   = $_POST['remark']   ?? '';

// 連接資料庫
$pdo = db_open();

// SQL 語法
$sqlstr = "INSERT INTO rest(
   restcode,
   restname,
   address,
   time,
   tel,
   intro,
   descr,
   resttype,
   google,
   menulist,
   remark)
   VALUES (
   :restcode,
   :restname,
   :address,
   :time,
   :tel,
   :intro,
   :descr,
   :resttype,
   :google,
   :menulist,
   :remark)";

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

// 執行 SQL
try { 
   $sth->execute();

   $new_uid = $pdo->lastInsertId();    // 傳回剛才新增記錄的 auto_increment 的欄位值
   $lnk_display = "display.php?uid=" . $new_uid . '&nump=' . $nump . '&page=99999';
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