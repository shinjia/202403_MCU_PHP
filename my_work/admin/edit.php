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
        $intro    = html_encode($row['intro']);
        $descr    = html_encode($row['descr']);
        $pub_date = html_encode($row['pub_date']);
        $picture  = html_encode($row['picture']);
        $tags     = html_encode($row['tags']);
        $category = html_encode($row['category']);
        $score    = html_encode($row['score']);
        $is_open  = intval($row['is_open']);  // is_open 欄位要處理
        $remark   = html_encode($row['remark']);
        

        // part2: 製作表單元件
        // 欄位1 (category)
        $str_category = '<select name="category">';
        foreach($a_category as $key=>$value) {
            $tmp = ($key==$category) ? 'selected="selected"' : '';
            $str_category .= '<option value="' . $key . '" ' . $tmp . '>' . $value . '</option>';
        }
        $str_category .= '</select>';

        // 欄位2 (score)
        $str_score = '';
        foreach($a_score as $key=>$value) {
            $tmp = ($key==$score) ? 'checked="checked"' : '';
            $str_score .= '<input type="radio" name="score" value="' . $key . '" ' . $tmp . '>' . $value;
            $str_score .= '<br>';
        }

        // 欄位3 (is_open)
        $tmp = ($is_open==0) ? '' : 'checked="checked"';
        $str_is_open = '<input type="checkbox" name="is_open" value="Y" ' . $tmp . '> 是否設定為發佈';

        // 網頁連結
        $lnk_list = 'list_page.php?uid=' . $uid . '&page=' . $page . '&nump=' . $nump;

        $data = <<< HEREDOC
        <button onclick="location.href='{$lnk_list}';" class="btn btn-primary">返回列表</button>
        <form action="edit_save.php" method="post">
        <table class="table">
            <tr><th>代碼</th><td><input type="text" name="workcode" value="{$workcode}"></td></tr>
            <tr><th>名稱</th><td><input type="text" name="workname" value="{$workname}"></td></tr>
            <tr><th>介紹</th><td><input type="text" name="intro"    value="{$intro}"></td></tr>
            <tr><th>說明</th><td><input type="text" name="descr"    value="{$descr}"></td></tr>
            <tr><th>日期</th><td><input type="text" name="pub_date" value="{$pub_date}"></td></tr>
            <tr><th>照片</th><td><input type="text" name="picture"  value="{$picture}"></td></tr>
            <tr><th>標籤</th><td><input type="text" name="tags"     value="{$tags}"></td></tr>
            <tr><th>分類</th><td>({$category}) {$str_category}</td></tr>
            <tr><th>評分</th><td>({$score}) {$str_score}</td></tr>
            <tr><th>發佈</th><td>({$is_open}) {$str_is_open}</td></tr>
            <tr><th>備註</th><td><input type="text" name="remark"   value="{$remark}"></td></tr>
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