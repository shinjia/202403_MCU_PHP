<?php
// 取得表單傳來的資料
$nickname = $_POST['nickname'] ?? '';
$comment = $_POST['comment'] ?? '';

// 設定
$is_mail = true;
$is_line = false;


// 設定 (時區)
ini_set('date.timezone', 'Asia/Taipei');

// 設定 (email)
ini_set('SMTP', 'msa.hinet.net');
ini_set('smtp_port', 25);
ini_set('sendmail_from', 'xxxx@xxx.hinet.net');

// 取得現在日期時間
$today = date('Y-m-d H:i:s', time());

// 要存到檔案的內容 (最後要多按一個ENTER)
$data = <<< HEREDOC
----------------------------------
時間：{$today}
姓名：{$nickname}
內容：{$comment}

HEREDOC;

// 指定檔名
// $filename = 'save/data_20240312.txt';
$dir = 'save';  // 資料夾
$filename = $dir . '/data_' . date('Ymd', time()) . '.txt';

// 若無，則建立資料夾
if(!is_dir($dir)){
    mkdir($dir, 0777);  // 開放讀寫權限
}

// 先確認檔案必須存在，若無則先產生
if(!file_exists($filename)) {
    file_put_contents($filename, '');
 }
 
// 寫入檔案
// 法一：直接新增到後面
// file_put_contents($filename, $data, FILE_APPEND);

// 法二：新留言放前面
$old = file_get_contents($filename);
$new = $data . $old;
file_put_contents($filename, $new);

// 寄信功能
if($is_mail) {
    $content = 'Hello 這是PHP寄信測試，<br>HTML格式呢？';
    $content .= '客戶留言如下：';
    $content .= $data;

    $to = 'xxx@gmail.com';
    $title = '有客戶留言';

    // 信件寄出
    $is_send = mail($to, $title, $content);
    $msg_mail = '寄信通知管理者：';
    $msg_mail .= $is_send ? '成功' : '失敗';
}



// LINE 通知
// Line Notify: PHP_LINE
if($is_line) {
    $token = '********';  // 更換自己的 token

    $url = "https://notify-api.line.me/api/notify";

    $headers = array(
    'Content-Type: multipart/form-data',
    'Authorization: Bearer ' . $token);

    // $message = array('message' => $data);

    $message = array(
    'message' => $data,
    'imageFile' => curl_file_create('C:\\xampp\htdocs\myweb\line\images\dog.png'),
    'stickerPackageId' => 446,
    'stickerId' => 1988
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL , $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
    $result = curl_exec($ch);
    curl_close($ch);
}


// 顯示在網頁的留言內容
$data_show = nl2br(htmlspecialchars($data));


// 顯示網頁
$html = <<< HEREDOC
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>已收到留言！</h1>
<p>你的留言資料如下：</p>
<div style="background-color:#FFFF99; border:1px solid red;">
{$data_show}
</div>

</body>
</html>
HEREDOC;

echo $html;
?>