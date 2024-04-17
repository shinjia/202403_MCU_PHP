<?php
include 'utility.php';

$type = $_GET['type'] ?? 'default';

$html = error_message($type);

include 'pagemake.php';
pagemake($html, '');
?>