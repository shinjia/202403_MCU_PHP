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
$sqlstr = "SELECT * FROM work ";

// 執行 SQL
try { 
    $sth = $pdo->query($sqlstr);

    $total_rec = $sth->rowCount();
    $cnt = 0;
    $data = '';
    while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        $uid = $row['uid'];
        $workcode = html_encode($row['workcode']);
        $workname = html_encode($row['workname']);
        $intro    = html_encode($row['intro']);
        $descr    = html_encode($row['descr']);
        $pub_date = html_encode($row['pub_date']);
        $picture  = html_encode($row['picture']);
        $tags     = html_encode($row['tags']);
        $category = html_encode($row['category']);
        $score    = html_encode($row['score']);
        $is_open  = html_encode($row['is_open']);
        $remark   = html_encode($row['remark']);
    
        $cnt++;

        $data .= <<< HEREDOC
        <tr>
            <th class="table-secondary text-center">{$cnt}</th>
            <td>{$workcode}</td>
            <td>{$workname}</td>
            <td>{$intro}</td>
            <td>{$descr}</td>
            <td>{$pub_date}</td>
            <td>{$picture}</td>
            <td>{$tags}</td>
            <td>{$category}</td>
            <td>{$score}</td>
            <td>{$is_open}</td>
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
            <th>代碼</th>
            <th>名稱</th>
            <th>簡介</th>
            <th>內容</th>
            <th>日期</th>
            <th>照片</th>
            <th>標籤</th>
            <th>分類</th>
            <th>評分</th>
            <th>發佈</th>
            <th>備註</th>
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