<?php
// 因為 JavaScript AJAX 的程式偵錯較困難，
// 所以先用簡單的PHP同步方式，用來檢查 upload_save.php 程式的正確。
// 使用這支程式前，需將 upload_save.php 最後的回傳 JSON 改為 echo 網頁。

$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>檔案上傳</title>
</head>
<body>
<h1>檔案上傳</h1>
<form name="form1" method="post" action="upload_save.php" enctype="multipart/form-data"> 
    <input type="hidden" name="MAX_FILE_SIZE" value="5000000"> 
    檔案：<input type="file" name="file"><br>
    <input type="submit" value="上傳">
</form>
</body>
</html>
HEREDOC;

echo $html;
?>