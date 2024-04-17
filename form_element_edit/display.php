<?php
include 'define.php';

$row = file(DB_FILE);
if($row) {
    // 從檔案讀入的資料要確認格式
    $category = trim($row[0]);
    $score    = intval($row[1]);
    $is_open  = intval($row[2]);

    // 對欄位顯示進行處理
    $str_category = $a_category[$category] ?? '(查無對應的值)';
    $str_score = $a_score[$score] ?? '(查無對應的值)';
    $str_is_open = $a_is_open[$is_open] ?? '(查無對應的值)';
}

$data_row = print_r($row, true);


$html = <<< HEREDOC
<h1>display</h1>
<h2>row 陣列的原始資料</h2>
{$data_row}

<h2>欄位的值顯示如下</h2>
<table border="1">
    <tr>
        <th>欄位名稱</th>
        <th>儲存的值</th>
        <th>顯示</th>
    </tr>
    <tr>
        <th>category</th>
        <td>{$category}</td>
        <td>{$str_category}</td>
    </tr>
    <tr>
        <th>score</th>
        <td>{$score}</td>
        <td>{$str_score}</td>
    </tr>
    <tr>
        <th>is_open</th>
        <td>{$is_open}</td>
        <td>{$str_is_open}</td>
    </tr>
</table>

HEREDOC;

include 'pagemake.php';
pagemake($html);
?>