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

include '../common/function.get_entry_in_dir.php';

// 接收傳入變數
$uid = $_GET['uid'] ?? 0;
$page = $_GET['page'] ??  1;   // 目前的頁碼
$nump = $_GET['nump'] ?? 10;   // 每頁的筆數


// 網頁內容預設
$ihc_content = '';
$ihc_error = '';

// 連接資料庫
$pdo = db_open();

// SQL 語法
$sqlstr = "SELECT * FROM work WHERE uid=?";

$sth = $pdo->prepare($sqlstr);
$sth->bindValue(1, $uid, PDO::PARAM_INT);

// 執行 SQL
try {
    $sth->execute();
    
    if($row = $sth->fetch(PDO::FETCH_ASSOC)) {
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
        
        // is_open 欄位要處理
        $is_open = intval($is_open);

        // 對欄位顯示進行處理
        $str_category = $a_category[$category] ?? '(查無對應的值)';
        $str_score = $a_score[$score] ?? '(查無對應的值)';
        $str_is_open = $a_is_open[$is_open] ?? '(查無對應的值)';

        // 主要圖片
        $file_img = PATH_UPLOAD_ROOT . $workcode . '/' . $picture;
        if(!file_exists($file_img)) {
            $file_img = PATH_UPLOAD_ROOT . $workcode . '/00default.jpg';
        }
        // <img src="{$file_img}" style="max-width:100px; max-height:100px;">

        $data = <<< HEREDOC
        <table class="table">
            <tr><th>代碼</th><td>{$workcode}</td></tr>
            <tr><th>名稱</th><td>{$workname}</td></tr>
            <tr><th>簡介</th><td>{$intro}</td></tr>
            <tr><th>說明</th><td>{$descr}</td></tr>
            <tr><th>日期</th><td>{$pub_date}</td></tr>
            <tr><th>圖片</th>
                <td>
                    {$picture} <img src="{$file_img}" style="max-width:100px; max-height:100px;">
                </td>
            </tr>
            <tr><th>標籤</th><td>{$tags}</td></tr>
            <tr><th>分類</th><td>({$category}) {$str_category}</td></tr>
            <tr><th>評分</th><td>({$score}) {$str_score}</td></tr>
            <tr><th>發佈</th><td>({$is_open}) {$str_is_open}</td></tr>
            <tr><th>備註</th><td>{$remark}</td></tr>
        </table>
HEREDOC;

        // 網頁連結
        $lnk_prev = 'list_page.php?uid=' . $uid . '&page=' . $page . '&nump=' . $nump;
        $lnk_edit = 'edit.php?uid=' . $uid . '&page=' . $page . '&nump=' . $nump;
        $lnk_delete = 'delete.php?uid=' . $uid . '&page=' . $page . '&nump=' . $nump;;
        $lnk_upload = 'upload_input.php?workcode=' . $workcode . '&uid=' . $uid . '&page=' . $page . '&nump=' . $nump;

        // 網頁內容
        $ihc_content = <<< HEREDOC
        <p>
            <button onclick="location.href='{$lnk_prev}';" class="btn btn-info">返回列表</button>
            <button onclick="location.href='{$lnk_edit}';" class="btn btn-warning">修改</button>
            <button onclick="location.href='{$lnk_upload}';" class="btn btn-success">上傳圖片</button>
            <button onclick="if(confirm('確定要刪除嗎？')) {location.href='{$lnk_delete}';}" class="btn btn-danger">刪除</button>
        </p>
        {$data}
HEREDOC;
    }
    else {
        $ihc_data = '<p class="center">查不到相關記錄！</p>';
    }
}
catch(PDOException $e) {
    $ihc_error = error_message('ERROR_QUERY', $e->getMessage());
}

db_close();

// 顯示圖檔部份

// 依類型定義相對應的路徑目錄
$path_img = PATH_UPLOAD_ROOT . $workcode;

// 讀取目錄列出檔案
$a_dir = get_entry_in_dir($path_img, 'FILE');  // 讀取實際檔案
if(!empty($a_dir)) {
    sort($a_dir);

    // 移除非 .jpg 檔
    foreach($a_dir as $key=>$value) {
        $tmp=explode('.', $value);
        $file_ext   = end($tmp);  // 最後一個小數點後的文字為副檔名
        if(strtolower($file_ext)!='jpg') {
            unset($a_dir[$key]); 
        }
    }
}
// echo $path_img;
// echo '<pre>';
// print_r($a_dir);
// echo '</pre>';

$cnt = 0;
$columns = 3;
$data = '<div>';
foreach($a_dir as $one) {  
    $file_show = $path_img . '/' . $one;
    $file_link = $path_img . '/' . $one;

    $img_size = 240;
    $show_w = 240 + 10;
    $show_h = 240 + 20;

    $data .= '<img src="' . $file_show . '" style="padding:6px; vertical-align: middle; max-width:' . $img_size . 'px; max-height:' . $img_size . 'px; _width:expression(this.width > ' . $img_size . ' && this.width > this.height ? ' . $img_size . ': auto);">';
}
$data .= '</div>';


$lnk_img = 'img_display.php?workcode=' . $workcode . '&uid=' . $uid . '&page=' . $page . '&nump=' . $nump;


//網頁顯示
$html = <<< HEREDOC
<h2>詳細資料</h2>
{$ihc_content}
{$ihc_error}
<hr>
<p><a href="{$lnk_img}" class="btn btn-primary">管理圖檔</a></p>
{$data}
<br>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>