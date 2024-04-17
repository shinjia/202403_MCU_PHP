<?php
session_start();

include 'define.php';

$ss_usertype = $_SESSION[SYSTEM_CODE.'usertype'] ?? '';
$ss_usercode = $_SESSION[SYSTEM_CODE.'usercode'] ?? '';

$id = session_id();
$var_usertype = DEF_SESSION_USERTYPE;
$var_usercode = DEF_SESSION_USERCODE;

$html = <<< HEREDOC
<p>此程式為查看session的變數內容，謹供程式開發測試用。</p>
<p>SESSION ID：<span style="color:#FF0000;">{$id}</span>
<ul>
    <li>usertype 的 SESSION 變數名稱：<span style="color:#FF0000;">{$var_usertype}</span></li>
    <li>usercode 的 SESSION 變數名稱：<span style="color:#FF0000;">{$var_usertype}</span></li>
</ul>

<h3>系統內存放的 SESSION 變數</h3>
HEREDOC;

$html .= '<pre>';
$html .= print_r($_SESSION, true);
$html .= '</pre>';

include 'pagemake.php';
pagemake($html);
?>