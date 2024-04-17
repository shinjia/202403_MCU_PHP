<?php
/***** 測試讀取記錄後，顯示不同的報表 *****/

/*****************************
報表一：大總表
直接把記錄檔顯示出來

報表二：給餐廳看看的訂單狀況
依各項目排序，列出數量及附註及姓名，計算總數量及總金額

報表三：給管理者分配餐點時看的
依人員代號排序
*****************************/

// 注意：該解決問題：
// 同樣代號的人輸入兩筆會造成錯誤?!


// 一些畫面設定參數
$css1 = 'background-color: #FFAAAA;';  // 重要強調
$css2 = 'background-color: #FFFFAA;';  // 

// 要讀取的檔案
$file_rec = '__rec.txt';

// 讀取檔案並解析出各列(rows)及各行(columns)
$data = file_get_contents($file_rec);
$rows = explode("\n", $data);

$total_price = 0;
$total_amt = 0;

// 整理以項目分類的彙總
$a_allitem = [];  // 所有筆數的 item 合併
foreach ($rows as $idx=>$row) {
    if ($idx==0 || trim($row)=='') continue; // 跳過標題和空列
    $columns = explode(',', $row);

    $membcode = $columns[0];  // 代碼
    $membname = $columns[1];  // 姓名
    $price_auto = $columns[2];  // 金額(試算)
    $price_user = $columns[3];  // 金額(輸入)
    $rec_time = $columns[count($columns)-1];  // 時間

    $total_price += (int) $price_user; // 累加總金額

    $a_oneitem = [];  // 單一筆的各個項目
    // 中間是各個項目，每個項目三欄
    for($i=4; $i<count($columns)-1; $i+=3) {
        $i_code = $columns[$i];  // 項目代碼
        $i_amt = (int) $columns[$i+1];  // 數量
        $i_note = $columns[$i+2] ?? '';  // 附註

        // 項目空的不記錄
        if($i_amt==0) continue;

        $total_amt += $i_amt; // 累加總數量
        $a_one = ['amt'=>$i_amt, 'note'=>$i_note, 'user'=>('('.$membcode.')'.$membname)];

        // 整理到單筆
        $a_item[$i_code] = $a_one;
        
        // 整理到彙總
        if(!isset($a_allitem[$i_code])) {
            $a_allitem[$i_code] = [];
        }
        array_push($a_allitem[$i_code], $a_one);
    }
}
ksort($a_allitem);  // 依項目代碼排序

// 整理以人員分類彙總
// 同樣的代號會創建新的代號，以避免混淆
$a_memb = [];
foreach ($rows as $key=>$row) {
    if ($key==0 || trim($row)=='') continue; // 跳過標題和空列
    $columns = explode(',', $row);
    $membcode = $columns[0];  // 代碼
    // $membname = $columns[1];  // 姓名
    // $price_auto = $columns[2];  // 金額(試算)
    // $price_user = $columns[3];  // 金額(輸入)
    // $rec_time = $columns[count($columns)-1];  // 時間

    // 注意：同樣代號的人輸入兩筆，要自動改代號
    $key1 = $membcode;
    if(isset($a_memb[$key1])) {
        $key1 = $membcode . '-' . uniqid();
    }
    $a_memb[$key1] = $columns;
}
ksort($a_memb);  // 依人員代碼排序

echo '<pre>';
print_r($rows);
print_r($a_allitem);
print_r($a_memb);
echo '</pre>';
// exit;



// 報表(一)：大總表
// 依 $a_memb 進行輸出
$str1 = '';
$str1 .= '<table border="1">';
// 表格表頭
$str1 .= '<tr>';
$str1 .= ' <th>人員</th>';
$str1 .= ' <th>試算</th>';
$str1 .= ' <th>輸入金額</th>';
// 中間是各個項目，每個項目三欄
for($i=4; $i<count($columns)-1; $i+=3) {
    $i_code = $columns[$i];  // 項目代碼
    // $i_amt = (int) $columns[$i+1];  // 數量
    // $i_note = $columns[$i+2] ?? '';  // 附註
    $str1 .= '<th colspan="2">' . $i_code . '</th>';
}
$str1 .= ' <th>時間</th>';
$str1 .= '<tr>';
// 表格內容
foreach($a_memb as $membcode=>$columns) {
    $membname = $columns[1];  // 姓名
    $price_auto = $columns[2];  // 金額(試算)
    $price_user = $columns[3];  // 金額(輸入)
    $rec_time = $columns[count($columns)-1];  // 時間
    
    $str1 .= '<tr>';
    $str1 .= '<td style="' . $css2 . '">' . $membcode . ' (' . $membname . ')</td>';
    $str1 .= '<td>' . $price_auto . '</td>';
    $str1 .= '<td style="' . $css2 . '">' . $price_user . '</td>';
    
    // 中間是各個項目，每個項目三欄
    for($i=4; $i<count($columns)-1; $i+=3) {
        $i_code = $columns[$i];  // 項目代碼
        $i_amt = (int) $columns[$i+1];  // 數量
        $i_note = $columns[$i+2] ?? '';  // 附註
        
        $css_cell = ($i_amt>0) ? $css1 : '';
        // $str1 .= '<td>' . $i_code . '</td>';
        $str1 .= '<td style="' . $css_cell . '">' . $i_amt . '</td>';
        $str1 .= '<td>' . $i_note . '</td>';
    }
    $str1 .= '<td>' . $rec_time . '</td>';    
    $str1 .= '</tr>';
}
$str1 .= '<table>';



// 輸出結果 (報表二)
$str2 = '';
$str2 .= '<table border="1">';
foreach ($a_allitem as $i_code=>$a_value) {
    if(empty($a_value)) continue;
    $sub_amt = 0;
    $str2 .= <<< HEREDOC
    <tr style="{$css1}">
        <th colspan="3" style="text-align:left;">{$i_code}</th>
    </tr>
    <tr>
        <th>數量</th>
        <th>附註</th>
        <th>姓名</th>
    </tr>
HEREDOC;
    foreach($a_value as $key=>$a_one) {
        $sub_amt += $a_one['amt'];
        $str2 .= '<tr>';
        $str2 .= '  <td>' . $a_one['amt'] . '</td>';
        $str2 .= '  <td>' . $a_one['note'] . '</td>';
        $str2 .= '  <td>' . $a_one['user'] . '</td>';
        $str2 .= '</tr>';
    }
    $str2 .= <<< HEREDOC
        <tr>
            <td style="{$css2}">{$sub_amt}</td>
            <td colspan="3">數量合計</td>
        </tr>
HEREDOC;
}
$str2 .= <<< HEREDOC
    </table>
    <p>
        總數量：{$total_amt}<br>
        總金額：{$total_price}
    </p>
HEREDOC;



// 輸出結果 (報表三)
$str3 = '';
$str3 .= <<< HEREDOC
<table border="1">
    <tr>
        <th>人員</th>
        <th>原金額<br>(項目)</th>
        <th>輸入金額<br>(數量)</th>
        <th>時間<br>(附註)</th>
    </tr>
HEREDOC;
foreach($a_memb as $membcode=>$columns) {
    // $membcode = $columns[0];  // 代碼
    $membname = $columns[1];  // 姓名
    $price_auto = $columns[2];  // 金額(試算)
    $price_user = $columns[3];  // 金額(輸入)
    $rec_time = $columns[count($columns)-1];  // 時間

    $str3 .= <<< HEREDOC
    <tr style="{$css2}">
        <td style="{$css1}">({$membcode}) {$membname}</td>
        <td>{$price_auto}</td>
        <td style="{$css1};">{$price_user}</td>
        <td>{$rec_time}</td>
    </tr>
HEREDOC;
    $a_oneitem = [];  // 單一筆的各個項目
    // 中間是各個項目，每個項目三欄
    for($i=4; $i<count($columns)-1; $i+=3) {
        $i_code = $columns[$i];  // 項目代碼
        $i_amt = (int) $columns[$i+1];  // 數量
        $i_note = $columns[$i+2] ?? '';  // 附註

        // 項目空的不記錄
        if($i_amt==0) continue;

        $a_one = ['amt'=>$i_amt, 'note'=>$i_note];
        $str3 .= <<< HEREDOC
        <tr>
            <td>&nbsp;</td>
            <td>{$i_code}</td>
            <td>{$i_amt}</td>
            <td>{$i_note}</td>
        </tr>
HEREDOC;
    }
}
$str3 .= '</table>';



// 網頁
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

<h3>(報表一) 大總表</h3>
{$str1}
<hr>

<h3>(報表二) 依各項目排序</h3>
{$str2}
<hr>

<h3>(報表三) 依人員排序</h3>
{$str3}
<hr>

</body>
</html>
HEREDOC;

echo $html;
?>