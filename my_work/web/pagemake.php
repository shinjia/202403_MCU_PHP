<?php

function pagemake($content='', $head='') {  
    $html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>dbs_work</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="style.css" rel="stylesheet">
{$head}
</head>
<body>

<div class="container">
    <div id="header">
        <h1>my_work</h1>
    </div>
    
    <div id="nav">     
        | <a href="index.php" target="_top">首頁</a>
        | <a href="list_page.php">資料列表</a>
        |
    </div>
    
    <div id="main">
        {$content}
    </div>

    <div id="footer">
        <p>版權聲明</p>
    </div>

</div>

</body>
</html>  
HEREDOC;

echo $html;
}

?>