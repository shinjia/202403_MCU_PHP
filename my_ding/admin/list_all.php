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

// 網頁內容預設
$ihc_content = '';
$ihc_error = '';

// 變數設定
$total_rec = 0;

// 連接資料庫
$pdo = db_open();

// SQL 語法
$sqlstr = "SELECT * FROM rest ";

// 執行 SQL
try { 
    $sth = $pdo->query($sqlstr);

    $total_rec = $sth->rowCount();
    $cnt = 0;
    $data = '';
    while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
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
    
        $cnt++;

        $data .= <<< HEREDOC
        <tr>
            <th class="table-secondary text-center">{$cnt}</th>
            <td>{$restcode}</td>
            <td>{$restname}</td>
            <td>{$address}</td>
            <td>{$time}</td>
            <td>{$tel}</td>
            <td>{$intro}</td>
            <td>{$descr}</td>
            <td>{$resttype}</td>
            <td>{$google}</td>
            <td>{$menulist}</td>
            <td>{$remark}</td>
        </tr>
HEREDOC;
    }

   //網頁顯示
    $ihc_content = <<< HEREDOC
    <h3 class="text-center">共有 {$total_rec} 筆記錄</h3>
    <table class="table table-hover">
        <tr class="table-secondary">
            <th class="text-center">順序</th>
            <th>餐廳代碼</p>
            <th>餐廳名稱</p>
            <th>餐廳地址</p>
            <th>餐廳時間</p>
            <th>餐廳電話</p>
            <th>內容簡介</p>
            <th>詳細說明</p>
            <th>餐廳類型</p>
            <th>Google評分</p>
            <th>菜單項目</p>
            <th>備註</p>
        </tr>
    {$data}
    </table>
HEREDOC;

    // 找不到資料時
    if($total_rec==0) { $ihc_content = '<p class="center">無資料</p>';}
}
catch(PDOException $e) {
    $ihc_error = error_message('ERROR_QUERY', $e->getMessage());
}

db_close();


$html = <<< HEREDOC
<h2>資料列表 (全部)</h2>
{$ihc_content}
{$ihc_error}
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>