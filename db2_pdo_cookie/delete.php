<?php
include 'config.php';
include 'utility.php';

// 接收傳入變數
$uid = $_GET['uid'] ?? 0;

// 寫入 cookie
setcookie('uid', $uid, time()+86400*7);

// 連接資料庫
$pdo = db_open();

// SQL 語法
$sqlstr = "DELETE FROM person WHERE uid=?";

$sth = $pdo->prepare($sqlstr);
$sth->bindValue(1, $uid, PDO::PARAM_INT);

// 執行 SQL
try { 
    $sth->execute();

    $refer = $_SERVER['HTTP_REFERER'];  // 呼叫此程式之前頁
    header('Location: ' . $refer);
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