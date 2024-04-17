<?php
include 'define.php';

// 欄位1 (category)
$str_category = '<select name="category">';
$str_category .= '<option value="X">請下拉選擇一項</option>';
foreach($a_category as $key=>$value) {
    $str_category .= '<option value="' . $key . '">' . $value . '</option>';
}
$str_category .= '</select>';

// 欄位2 (score)
$str_score = '';
foreach($a_score as $key=>$value) {
    $str_score .= '<input type="radio" name="score" value="' . $key . '">' . $value;
    $str_score .= '<br>';
}

// 欄位3 (is_open)
$str_is_open = '<input type="checkbox" name="is_open" value="Y"> 已發佈';


$html = <<< HEREDOC
<h1>add</h1>
<h2>設定各欄位的值</h2>
<form method="post" action="add_save.php">
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