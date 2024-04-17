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
$sqlstr = "SELECT count(*) as total_rec FROM work ";
$sqlstr .= " WHERE is_open=1 ";
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
$sqlstr = "SELECT * FROM work ";
$sqlstr .= " WHERE is_open=1 ";
$sqlstr .= " LIMIT " . (($page-1)*$nump) . "," . $nump;

// 執行 SQL
try { 
    $sth = $pdo->query($sqlstr);

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
        $str_picture = '<img src="' . $file_img . '" style="width:100%; height:100%;">';

        // tags 欄位增加超連結
        $a_tags = explode(',', $tags);
        array_map('trim', $a_tags);
        $str_tags = '';
        foreach($a_tags as $value) {
            $str_tags .= '[<a href="list_by.php?type=TAGS&key=' . $value . '">' . $value . '</a>] ';
        }
        
        // category 欄位增加超連結
        $str_category = '<a href="list_by.php?type=CATEGORY&key=' . $category . '">' . $a_category[$category] . '</a> ';


        // 超連結
        $lnk_display = 'display.php?uid=' . $uid . '&page=' . $page . '&nump=' . $nump;

        $data .= <<< HEREDOC
        <div style="display:flex; justify-content: center; align-items: center;">
            <div style="display:inline-block; border: 1px solid gray; padding: 0px 0px 10px 0px; margin:5px; 10px; border-radius:4px; overflow:hidden;">
                <div style="width:300px; height:300px; ">
                    <a href="{$lnk_display}">{$str_picture}</a>
                </div>
                <div>
                    {$workname}<br/>
                    分類：{$str_tags}<br>
                    標籤：{$str_category}<br>
                    ✰ ({$score})
                </div>
            </div>
        </div>
HEREDOC;
    }

    // 分頁導覽列
    $ihc_pagination = pagination($total_rec, $total_page, $page, $nump);

    //網頁顯示
    $ihc_content = <<< HEREDOC
    <nav>
        {$ihc_pagination}
    </nav>
    <div>
    {$data}
    </div>
HEREDOC;

    // 找不到資料時
    if($total_rec==0) { $ihc_content = '<p class="center">無資料</p>';}
}
catch(PDOException $e) {
    $ihc_error = error_message('ERROR_QUERY', $e->getMessage());
}

db_close();


$html = <<< HEREDOC
{$ihc_content}
{$ihc_error}
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>