<?php
include '../common/config.php';
include '../common/define.php';
include '../common/utility.php';

// 接收傳入變數
$uid = $_GET['uid'] ?? 0;
$page = $_GET['page'] ?? 1;   // 目前的頁碼
$nump = $_GET['nump'] ?? 10;   // 每頁的筆數

// 網頁內容預設
$ihc_content = '';
$ihc_error = '';

// 連接資料庫
$pdo = db_open();

// SQL 語法
$sqlstr = "SELECT * FROM work WHERE uid=? ";

$sth = $pdo->prepare($sqlstr);
$sth->bindValue(1, $uid, PDO::PARAM_INT);

// 執行 SQL
try { 
    $sth->execute();

    if($row = $sth->fetch(PDO::FETCH_ASSOC))
    {
        $uid = $row['uid'];

        $workcode = html_encode($row['workcode']);
        $workname = html_encode($row['workname']);
        $intro  = html_encode($row['intro']);
        $descr = html_encode($row['descr']);
        $pub_date   = html_encode($row['pub_date']);
        $picture   = html_encode($row['picture']);
        $remark   = html_encode($row['remark']);
        
        // 網頁連結
        $lnk_list = 'list_page.php?uid=' . $uid . '&page=' . $page . '&nump=' . $nump;

        $data = <<< HEREDOC
        <button onclick="location.href='{$lnk_list}';">返回列表</button>
        <form action="edit_save.php" method="post">
        <table>
            <tr><th>代碼</th><td><input type="text" name="workcode" value="{$workcode}"></td></tr>
            <tr><th>姓名</th><td><input type="text" name="workname" value="{$workname}"></td></tr>
            <tr><th>地址</th><td><input type="text" name="intro" value="{$intro}"></td></tr>
            <tr><th>生日</th><td><input type="text" name="descr" value="{$descr}"></td></tr>
            <tr><th>身高</th><td><input type="text" name="pub_date" value="{$pub_date}"></td></tr>
            <tr><th>體重</th><td><input type="text" name="picture" value="{$picture}"></td></tr>
            <tr><th>備註</th><td><input type="text" name="remark" value="{$remark}"></td></tr>
        </table>
        <p>
            <input type="hidden" name="uid" value="{$uid}">
            <input type="hidden" name="page" value="{$page}">
            <input type="hidden" name="nump" value="{$nump}">
            <input type="submit" value="送出">
        </p>
        </form>
HEREDOC;
    }
    else {
        $data = '<p>無資料</p>';
    }

    //網頁顯示
    $ihc_content = <<< HEREDOC
    <div>
        {$data}
    </div>
HEREDOC;
}
catch(PDOException $e) {
    // db_error(ERROR_QUERY, $e->getMessage());
    $ihc_error = error_message('ERROR_QUERY', $e->getMessage());
}

db_close();


//網頁顯示
$html = <<< HEREDOC
<h2>修改資料</h2>
{$ihc_content}
{$ihc_error}
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>