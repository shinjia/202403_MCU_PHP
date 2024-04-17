<?php
include 'config.php';
include 'utility.php';

$uid = $_GET['uid'];

// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
$sqlstr = "SELECT * FROM person WHERE uid=" . $uid;

// 執行 SQL
$sth = $pdo->query($sqlstr);
if($row = $sth->fetch(PDO::FETCH_ASSOC)) {
   $uid = $row['uid'];
   $usercode = html_encode($row['usercode']);
   $username = html_encode($row['username']);
   $address  = html_encode($row['address']);
   $birthday = html_encode($row['birthday']);
   $height   = html_encode($row['height']);
   $weight   = html_encode($row['weight']);
   $remark   = html_encode($row['remark']);
   
   $data = <<< HEREDOC
     <table>
       <tr><th>代碼</th><td>{$usercode}</td></tr>
       <tr><th>姓名</th><td>{$username}</td></tr>
       <tr><th>地址</th><td>{$address}</td></tr>
       <tr><th>生日</th><td>{$birthday}</td></tr>
       <tr><th>身高</th><td>{$height}</td></tr>
       <tr><th>體重</th><td>{$weight}</td></tr>
       <tr><th>備註</th><td>{$remark}</td></tr>
     </table>
HEREDOC;
}
else {
 	 $data = '查不到相關記錄！';
}


$html = <<< HEREDOC
<button onclick="location.href='list_page.php';">返回列表</button>
<h2>顯示資料</h2>
{$data}
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>