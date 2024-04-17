<?php
session_start();

include 'define.php';

$ss_usertype = $_SESSION[DEF_SESSION_USERTYPE] ?? '';
$ss_usercode = $_SESSION[DEF_SESSION_USERCODE] ?? '';

if($ss_usertype!=DEF_LOGIN_ADMIN) {
    header('Location: login_error.php');
    exit;
}

//==============================================================================


$html = <<< HEREDOC
<h2>系統管理者</h2>
<p>這一支程式只有『系統管理員』才能執行</p>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>