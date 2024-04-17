<?php
include 'define.php';

// 取得表單傳來的值
$category = $_POST['category'] ?? '';
$score    = $_POST['score']    ?? '';
$is_open  = $_POST['is_open']  ?? '';

// checkbox 必須再檢查初始值
$is_open = ($is_open=='Y') ? 1 : 0;


$data = <<< HEREDOC
{$category}
{$score}
{$is_open}
HEREDOC;

$tmp = file_put_contents(DB_FILE , $data);
$str_data = nl2br($data);

$html = <<< HEREDOC
<h1>add_save</h1>
<h2>資料已寫入檔案</h2>
{$str_data}
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>