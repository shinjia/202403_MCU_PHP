<?php
/***** 測試使用者訂購畫面，訂購後存檔 *****/

$restcode = 'xxx'; 
$restdata = '****假設這裡是關於餐廳的各項資料****';

$menulist = '

L101, 熱拿鐵(中), 120, 中杯
L102, 熱拿鐵(大), 150, 大杯
L103, 卡布其諾(中), 130, 中杯
L104, 卡布其諾(大), 130, 大杯


';


$a_menu = explode("\n", $menulist);  // 使用 PHP_EOL 處理當前環境的換行符
$a_menu = array_filter($a_menu);  // 移除空白列

$data = <<< HEREDOC
    <form method="post" action="test2_x.php">
    <table border="1">
    <tr>
        <th>項目</th>
        <th>名稱</th>
        <th>單價</th>
        <th>備註</th>
        <th>數量</th>
        <th>操作</th>
        <th>附註</th>
    </tr>
HEREDOC;

$i = 0;
foreach($a_menu as $value) {
    $a_item = explode(',', $value);
    array_map('trim', $a_item);
    $f_code = $a_item[0];
    $f_name = $a_item[1];
    $f_price = $a_item[2];
    $f_note = $a_item[3];

    $data .= <<< HEREDOC
    <tr id="row_{$i}">
        <td>{$f_code}</td>
        <td>{$f_name}</td>
        <td>{$f_price}</td>
        <td>{$f_note}</td>
        <td>
            <!--<input type="hidden" id="price_{$i}" value="{$f_price}">-->
            <input type="text" name="amt[{$f_code}]" id="amt_{$i}" value="0" size="1" >
        </td>
        <td><input type="text" name="note[{$f_code}]" value="" size="4"></td>
    </tr>
HEREDOC;
    
    $i++;  // 遞增 id 的索引值
}

$data .= <<< HEREDOC
</table>
<p>
確認輸入總金額：<input type="text" name="price_user" required size="4">
</p>
<p>
訂購人代號：<input type="text" name="membcode" required><br>
訂購人姓名：<input type="text" name="membname" required>
</p>
<br><input type="submit" value="送出">
</form>
HEREDOC;


$html = <<< HEREDOC
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ding Test</title>
</head>
<body>
    <h2>訂餐系統主要操作頁面測試</h2>
    <h3>顯示餐廳的資訊</h3>
    <p>
    code: {$restcode}<br>
    data: {$restdata}
    </p>
    <h3>顯示菜單的資訊，可供輸入</h3>
    <div>
    {$data}
    </div>

</body>
</html>
HEREDOC;

echo $html;
?>