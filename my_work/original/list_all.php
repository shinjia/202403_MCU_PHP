<?php
include '../common/config.php';
include '../common/define.php';
include '../common/utility.php';

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
        $intro  = html_encode($row['intro']);
        $descr = html_encode($row['descr']);
        $pub_date   = html_encode($row['pub_date']);
        $picture   = html_encode($row['picture']);
        $remark   = html_encode($row['remark']);
    
        $cnt++;

        $data .= <<< HEREDOC
        <tr>
            <th>{$cnt}</th>
            <td>{$uid}</td>
            <td>{$workcode}</td>
            <td>{$workname}</td>
            <td>{$intro}</td>
            <td>{$descr}</td>
            <td>{$pub_date}</td>
            <td>{$picture}</td>
            <td>{$remark}</td>
            <td><a href="display.php?uid={$uid}">詳細</a></td>
            <td><a href="edit.php?uid={$uid}">修改</a></td>
            <td><a href="delete.php?uid={$uid}" onClick="return confirm('確定要刪除嗎？');">刪除</a></td>
        </tr>
HEREDOC;
    }

   //網頁顯示
    $ihc_content = <<< HEREDOC
    <h3>共有 {$total_rec} 筆記錄</h3>
    <table>
        <tr>
            <th>順序</th>
            <th>uid</th>
            <th>代碼</th>
            <th>姓名</th>
            <th>地址</th>
            <th>生日</th>
            <th>身高</th>
            <th>體重</th>
            <th>備註</th>
            <th colspan="3" align="center"><a href="add.php">新增記錄</a></th>
        </tr>
        {$data}
    </table>
HEREDOC;

    // 找不到資料時
    if($total_rec==0) { $ihc_content = '<p>無資料</p>';}
}
catch(PDOException $e) {
    // db_error(ERROR_QUERY, $e->getMessage());
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