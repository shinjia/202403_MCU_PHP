<?php
include 'define.php';

// part1: 先讀入資料
$row = file(DB_FILE);
if($row) {
    // 從檔案讀入的資料要確認格式
    $category = trim($row[0]);
    $score    = intval($row[1]);
    $is_open  = intval($row[2]);
}

$data_row = print_r($row, true);


// part2: 製作表單元件
// 欄位1 (category)
$str_category = '<select name="category">';
foreach($a_category as $key=>$value) {
    $tmp = ($key==$category) ? 'selected="selected"' : '';
    $str_category .= '<option value="' . $key . '" ' . $tmp . '>' . $value . '</option>';
}
$str_category .= '</select>';

// 欄位2 (score)
$str_score = '';
foreach($a_score as $key=>$value) {
    $tmp = ($key==$score) ? 'checked="checked"' : '';
    $str_score .= '<input type="radio" name="score" value="' . $key . '" ' . $tmp . '>' . $value;
    $str_score .= '<br>';
}

// 欄位3 (is_open)
$tmp = ($is_open==$a_is_open[0]) ? '' : 'checked="checked"';
$str_is_open = '<input type="checkbox" name="is_open" value="Y" ' . $tmp . '> 已發佈';

$html = <<< HEREDOC
<h2>edit</h2>
<form method="post" action="edit_save.php">
    <table border="1">
        <tr>
            <th>欄位名稱</th>
            <th>設定值</th>
        </tr>
        <tr>
            <th>category</th>
            <td>{$str_category}</td>
        </tr>
        <tr>
            <th>score</th>
            <td>{$str_score}</td>
        </tr>
        <tr>
            <th>is_open</th>
            <td>{$str_is_open}</td>
        </tr>
    </table>
    <input type="submit" value="送出">
</form>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>