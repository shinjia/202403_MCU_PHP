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
$uid = $_GET['uid'] ?? 0;
$page = $_GET['page'] ?? 1;   // 目前的頁碼
$nump = $_GET['nump'] ?? 10;   // 每頁的筆數

// 網頁內容預設
$ihc_content = '';
$ihc_error = '';

// 連接資料庫
$pdo = db_open();

// SQL 語法
$sqlstr = "SELECT * FROM rest WHERE uid=? ";

$sth = $pdo->prepare($sqlstr);
$sth->bindValue(1, $uid, PDO::PARAM_INT);

// 執行 SQL
try { 
    $sth->execute();

    if($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        $uid = $row['uid'];

        $restcode = html_encode($row['restcode']);
        $restname = html_encode($row['restname']);
        $address  = html_encode($row['address']);
        $time     = html_encode($row['time']);
        $tel      = html_encode($row['tel']);
        $intro    = html_encode($row['intro']);
        $descr    = html_encode($row['descr']);
        $resttype = html_encode($row['resttype']);
        $google   = html_encode($row['google']);
        $menulist = html_encode($row['menulist']);
        $remark   = html_encode($row['remark']);
        
        // 網頁連結
        $lnk_list = 'list_page.php?uid=' . $uid . '&page=' . $page . '&nump=' . $nump;

        $data = <<< HEREDOC
        <button onclick="location.href='{$lnk_list}';" class="btn btn-primary">返回列表</button>
        <form action="edit_save.php" method="post">
        <table class="table">
            <tr><th>餐廳代碼</th><td><input type="text" name="restcode" value="{$restcode}"></td></tr></p>
            <tr><th>餐廳名稱</th><td><input type="text" name="restname" value="{$restname}"></td></tr>
            <tr><th>餐廳地址</th><td><input type="text" name="address" value="{$address}"></td></tr>
            <tr><th>餐廳時間</th><td><input type="text" name="time" value="{$time}"></td></tr>
            <tr><th>餐廳電話</th><td><input type="text" name="tel" value="{$tel}"></td></tr>
            <tr><th>內容簡介</th><td><input type="text" name="intro" value="{$intro}"></td></tr>
            <tr><th>詳細說明</th><td><textarea name="descr">{$descr}</textarea></td></tr>
            <tr><th>餐廳類型</th><td><input type="text" name="resttype" value="{$resttype}"></td></tr>
            <tr><th>Google評分</th><td><input type="text" name="google" value="{$google}"></td></tr>
            <tr><th>菜單項目</th>
                <td>
                    注意格式：每列有四個欄位(代碼、名稱、價格、說明)，中間用逗號隔開
                    <textarea name="menulist" rows="8" cols="60">{$menulist}</textarea>
                </td>
            </tr>
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
        $data = '<p class="center">無資料</p>';
    }

    //網頁顯示
    $ihc_content = <<< HEREDOC
    <div>
        {$data}
    </div>
HEREDOC;
}
catch(PDOException $e) {
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