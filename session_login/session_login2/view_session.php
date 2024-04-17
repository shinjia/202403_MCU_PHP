<?php
session_start();

$ss_usertype = $_SESSION['usertype'] ?? '';
$ss_usercode = $_SESSION['usercode'] ?? '';

$id = session_id();

$html = <<< HEREDOC
<p>此程式為查看session的變數內容，謹供程式開發測試用。</p>
<p>SESSION ID：<span style="color:#FF0000;">{$id}</span>
<ul>
    <li>usertype: {$ss_usertype}</li>
    <li>usercode: {$ss_usercode}</li>
</ul>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>