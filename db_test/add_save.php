<?php
include 'config.php';

// 接受外部表單傳入之變數
$usercode = $_POST['usercode'] ?? '';
$username = $_POST['username'] ?? '';
$address  = $_POST['address']  ?? '';
$birthday = $_POST['birthday'] ?? '';
$height   = $_POST['height']   ?? 0;
$weight   = $_POST['weight']   ?? 0;
$remark   = $_POST['remark']   ?? '';

// 連接資料庫
$link = db_open();

// 寫出 SQL 語法
$sqlstr = "INSERT INTO person(usercode, username, address, birthday, height, weight, remark) 
           VALUES('$usercode', '$username', '$address', '$birthday', $height, $weight, '$remark') ";


// 執行SQL及處理結果
$result = @mysqli_query($link, $sqlstr) or die(ERROR_QUERY);
if($result) {
   $new_uid = mysqli_insert_id($link);   // 傳回剛才新增記錄的auto_increment欄位值
   $url_display = 'display.php?uid=' . $new_uid;
   echo 'Success....<br />Should redirect to next page: ' . $url_display;
   // header("Location: " . $url_display);
}
else {
   // header("Location: error.php");
   echo 'Fail....<br />Should redirect to error page<br />';
   echo mysqli_error($link) . '<br /b>' . $sqlstr;  // 此列供開發時期偵錯用，應刪除
}

db_close($link);

?>