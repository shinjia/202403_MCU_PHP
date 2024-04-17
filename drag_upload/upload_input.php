<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>拖放檔案上傳</title>
    <style>
        #drop_zone {
            border: 2px dashed #0087F7;
            border-radius: 5px;
            width: 480px;
            height: 200px;
            line-height: 80px;
            color: #0087F7;
            text-align: center;
            font-size: 24px;
            margin: 20px;
        }
    </style>
</head>
<body>

<div id="drop_zone">
    拖放檔案至此區域以上傳<br>
    <form method="post" action="upload_save2.php">
    <input type="file" name="file2" multiple="multiple">
    <input type="submit" value="上傳">
    </form>
</div>
<div id="show_zone">等候檔案上傳....</div>
    
<script src="drag_and_drop.js"></script>
</body>
</html>
