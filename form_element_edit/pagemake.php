<?php

function pagemake($content, $head='') {
    $html = <<< HEREDOC
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>表單元件的修改與顯示</h1>
    <p> |
        <a href="add.php">add 新增 (重設變數)</a> |
        <a href="display.php">display 顯示</a> |
        <a href="edit.php">edit 修改</a> |
    </p>
    <hr>
    <div>
        {$content}
    </div>
</body>
</html>
HEREDOC;

echo $html;
}

?>