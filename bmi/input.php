<?php



$html = <<< HEREDOC
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>BMI</h1>

    <form method="post" action="calc.php">
        <p>身高：<input type="text" name="height" required></p>
        <p>體重：<input type="text" name="weight"></p>
        <p><input type="submit" value="計算"></p>
    </form>

</body>
</html>
HEREDOC;

echo $html;
?>