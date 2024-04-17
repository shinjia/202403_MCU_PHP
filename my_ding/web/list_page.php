<?php
include '../common/config.php';
include '../common/define.php';
include '../common/utility.php';

// 頁碼參數
$page = $_GET['page'] ??  1;   // 目前的頁碼
$nump = $_GET['nump'] ?? 10;   // 每頁的筆數

// 增加傳入 uid，把該筆記錄高亮標示
$uid_highlight = $_GET['uid'] ?? '';

// 參數安全檢查
$page = intval($page);  // 轉為整數
$nump = intval($nump);  // 轉為整數
$page = ($page<=0) ? 1 : $page;  // 不可為零
$nump = ($nump<=0) ? 10 : $nump;  // 不可為零

// 網頁內容預設
$ihc_content = '';
$ihc_error = '';

// 變數設定
$total_rec = 0;
$total_page = 0;

// 連接資料庫
$pdo = db_open();

// SQL 語法：取得分頁所需之資訊 (總筆數、總頁數、擷取記錄之起始位置)
$sqlstr = "SELECT count(*) as total_rec FROM rest ";
$sth = $pdo->prepare($sqlstr);
try {
    $sth->execute();
    if($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        $total_rec = $row["total_rec"];
    }
    $total_page = ceil($total_rec / $nump);  // 計算總頁數
}
catch(PDOException $e) {
    $ihc_error = error_message(ERROR_QUERY, $e->getMessage());
}

// 頁數超過時，維持在最後一頁
if($page>$total_page && $total_page>0) {
    $page = $total_page;
}

// SQL 語法：分頁資訊
$sqlstr = "SELECT * FROM rest ";
$sqlstr .= " LIMIT " . (($page-1)*$nump) . "," . $nump;

// 執行 SQL
try { 
    $sth = $pdo->query($sqlstr);

    $cnt = (($page-1)*$nump);  // 注意分頁的起始順序
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
        // $menulist = html_encode($row['menulist']);
        $remark   = html_encode($row['remark']);
    
        $cnt++;

        // 指定的 uid 記錄高亮顯示
        $str_highlight = '';
        if($uid==$uid_highlight) {
            $str_highlight = 'class="hightlight table-warning"';
        }

        // 超連結
        $lnk_display = 'display.php?uid=' . $uid . '&page=' . $page . '&nump=' . $nump;

        $data .= <<< HEREDOC
        <tr {$str_highlight}>
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
            <td>{$remark}</td>
            <td class="table-secondary" style="width: 1%; white-space:nowrap;">
                <a href="{$lnk_display}" class="btn btn-info btn-sm">詳細</a>
            </td>
        </tr>
HEREDOC;
    }

    // 分頁導覽列
    $ihc_pagination = pagination($total_rec, $total_page, $page, $nump);
    
    $lnk_add = 'add.php?page=' . $page . '&nump=' . $nump;

    //網頁顯示
    $ihc_content = <<< HEREDOC
    <nav>
        {$ihc_pagination}
    </nav>
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
            <th>備註</p>
            <th class="text-center">操作</th>
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
<h2>資料列表 (分頁)</h2>
{$ihc_content}
{$ihc_error}
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>