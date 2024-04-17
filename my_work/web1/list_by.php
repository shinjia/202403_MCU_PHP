<?php

include '../common/config.php';
include '../common/define.php';
include '../common/utility.php';

// 頁碼參數
$page = $_GET['page'] ??  1;   // 目前的頁碼
$nump = $_GET['nump'] ?? 10;   // 每頁的筆數
$type = $_GET['type'] ?? 'XX';
$key = $_GET['key'] ?? '';

// 決定查詢的特別條件
$sql_where = '';
switch ($type) {
    case 'TAGS':
        $sql_where = " AND tags LIKE :keyword ";  // 依條件修改
        $keyword = '%' . $key . '%';  // 注意
        break;

    case 'CATEGORY':
        $sql_where = " AND category=:keyword ";  // 依條件修改
        $keyword = $key;  // 注意
        break;

    default:
        $sql_where = " AND false ";  // 依條件修改
        break;
}


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
$sqlstr = "SELECT count(*) as total_rec FROM work ";
$sqlstr .= " WHERE is_open=1 ";
$sqlstr .= $sql_where;

$sth = $pdo->prepare($sqlstr);
$sth->bindParam(':keyword', $keyword, PDO::PARAM_STR);
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
$sqlstr = "SELECT * FROM work ";
$sqlstr .= " WHERE is_open=1 ";
$sqlstr .= $sql_where;
$sqlstr .= " LIMIT " . (($page-1)*$nump) . "," . $nump;

$sth = $pdo->prepare($sqlstr);
$sth->bindParam(':keyword', $keyword, PDO::PARAM_STR);
// 執行 SQL
try { 
    // $sth = $pdo->query($sqlstr);
    $sth->execute();
    $sth->bindParam(':keyword', $keyword, PDO::PARAM_STR);

    $cnt = (($page-1)*$nump);  // 注意分頁的起始順序
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

        // 指定的 uid 記錄高亮顯示
        $str_highlight = '';
        if($uid==$uid_highlight) {
            $str_highlight = 'class="hightlight table-warning"';
        }
        
        // 主要圖片
        $file_img = PATH_UPLOAD_ROOT . $workcode . '/' . $picture;
        if(!file_exists($file_img)) {
            $file_img = PATH_UPLOAD_ROOT . $workcode . '/00default.jpg';
        }
        $str_picture = '<img src="' . $file_img . '" style="max-width:100px; max-height:100px;">';

        // 超連結
        $lnk_display = 'display.php?uid=' . $uid . '&page=' . $page . '&nump=' . $nump;
        $lnk_edit = 'edit.php?uid=' . $uid . '&page=' . $page . '&nump=' . $nump;
        $lnk_delete = 'delete.php?uid=' . $uid . '&page=' . $page . '&nump=' . $nump;

        $data .= <<< HEREDOC
        <tr {$str_highlight}>
            <th class="table-secondary text-center">{$cnt}</th>
            <td>{$workcode}</td>
            <td>{$workname}</td>
            <td>{$intro}</td>
            <td>{$descr}</td>
            <td>{$pub_date}</td>
            <td>{$str_picture}</td>
            <td>{$tags}</td>
            <td>{$category}</td>
            <td>{$score}</td>
            <td>{$is_open}</td>
            <td>{$remark}</td>
            <td class="table-secondary" style="width: 1%; white-space:nowrap;">
                <a href="{$lnk_display}" class="btn btn-info btn-sm">詳細</a>
            </td>
        </tr>
HEREDOC;
    }

    // 分頁導覽列
    $ihc_pagination = pagination($total_rec, $total_page, $page, $nump);

    //網頁顯示
    $ihc_content = <<< HEREDOC
    <nav>
        {$ihc_pagination}
    </nav>
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
            <th class="text-center">查看</th>
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