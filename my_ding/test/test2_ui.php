<?php
/***** 同 test2，但強化前端操作的功能 (JavaScript) *****/

$restcode = 'xxx'; 
$restdata = '****假設這裡是關於餐廳的各項資料****';

$menulist = '

L101, 熱拿鐵(中), 120, 中杯
L102, 熱拿鐵(大), 150, 大杯
L103, 卡布其諾(中), 130, 中杯
L104, 卡布其諾(大), 130, 大杯

L201, B熱拿鐵(中), 120, 中杯
L202, B熱拿鐵(大), 150, 大杯
L203, B卡布其諾(中), 130, 中杯
L204, B卡布其諾(大), 130, 大杯


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
            <input type="hidden" id="price_{$i}" value="{$f_price}">
            <input type="text" name="amt[{$f_code}]" id="amt_{$i}" value="0" readonly size="1" >
        </td>
        <td>
            <button onclick="add('amt_{$i}', 1);">加</a>
            <button onclick="add('amt_{$i}', -1);">減</a>
            
        </td>
        <td><input type="text" name="note[{$f_code}]" value="" size="4"></td>
    </tr>
HEREDOC;
    
    $i++;  // 遞增 id 的索引值
}

$data .= <<< HEREDOC
</table>
<p>
自動試算總金額：<input type="text" name="price_auto" id="price_auto" readonly size="4">
<br>
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

<script>
function add(_id, _cnt) {
    event.preventDefault();  // 取消按鈕的預設提交行為
    let obj = document.getElementById(_id);
    // 轉換當前值為數字並增加 _cnt
    let new_value = parseInt(obj.value) + _cnt;
    if(new_value<0) { new_value=0; }
    obj.value = new_value;
    calc_total();
}

function calc_total() {
    let total = 0;
    let i=0;
    // 迴圈遍歷直到元素不存在為止
    while(document.getElementById('price_'+i) && document.getElementById('amt_'+i)) {
        // 獲取 price 和 amt 的值
        var price = parseInt(document.getElementById('price_'+i).value);
        var amt = parseInt(document.getElementById('amt_'+i).value);
        // 計算乘積並累加到總額
        total += price * amt;
        
        // 變更整列的顏色
        bcolor = (amt!=0) ? '#FFFFAA' : '';
        document.getElementById('row_'+i).style.backgroundColor=bcolor;

        // 移至下一對元素
        i++;
    }
    document.getElementById('price_auto').value = total;
}
</script>
</body>
</html>
HEREDOC;

echo $html;
?>