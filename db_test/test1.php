<?php
$link = mysqli_connect('localhost', 'root', '', 'class');

$sqlstr = "INSERT INTO person(usercode, username, address, birthday, height, weight, remark) VALUES ('P100', 'Hello', '高雄', '1980-8-4', '170', '56', '') ";
mysqli_query($link, $sqlstr);

mysqli_close($link);

echo 'OK';
?>