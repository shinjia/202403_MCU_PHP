<?php
$a_want = $_POST['want'] ?? '';
$a_note = $_POST['note'] ?? '';

echo '<pre>';
print_r($a_want);
print_r($a_note);
echo '</pre>';
?>