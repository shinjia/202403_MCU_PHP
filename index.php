<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>PHP</title>
<base target="_blank">
<style>
h2 { background-color: #FF8800; color:#FFFF00; }    
</style>
</head>
<body>
<h3>PHP 老師上課實作</h3>

<div class="hot" style="background-color:rgb(235, 216, 189); padding:5px;">
    <p>(快速連結) db_系列程式：|
        <a href="db_mysqli/">db_mysqli</a> |
        <a href="db_pdo_sth/">db_pdo_sth</a> |
        <a href="db_ext2/">db_ext2</a> |
    </p>
</div>


<h2>Class 08 (2024/03/27)</h2>
<p>查詢程式</p>
<ul>
    <li><a href="db_mysqli/find.php">find.php (查詢姓名，用 list_all 修改)</a> 
        查看原始碼
        [<a href="show_source.php?dir=db_mysqli&amp;file=find.php">find.php</a>] 
        [<a href="show_source.php?dir=db_mysqli&amp;file=find_x.php">find_x.php</a>]
    </li>
    <li><a href="db_mysqli/findp.php">findp.php (查詢地區，分頁，用 list_page 修改)</a> 
        查看原始碼
        [<a href="show_source.php?dir=db_mysqli&amp;file=findp.php">findp.php</a>] 
        [<a href="show_source.php?dir=db_mysqli&amp;file=findp_x.php">findp_x.php</a>]
    </li>
</ul>
<p>&nbsp;</p>


<h2>Class 07 (2024/03/25)</h2>
<p>參考上列資料庫系列程式</p>
<p>&nbsp;</p>



<h2>Class 06 (2024/03/20)</h2>

<p>db_系列程式</p>
<ul>
    <li><a href="db_test/">db_test</a></li>
    <li><a href="db_mysqli/">db_mysqli</a></li>
</ul>

<p>PHP 連結 MySQL 的程式測試 (db_test)</p>
<ul>
    <li>查看原始碼：[<a href="show_source.php?dir=db_test&amp;file=test1.php">db_test/test1.php</a>]</li>
</li>
</ul>

<p>改出一套自己的資料庫練習程式</p>
<ul>
    <li><a href="my_book/">my_book 書籍資料管理</a></li>
</ul>

<p>&nbsp;</p>



<h2>Class 05 (2024/03/18)</h2>

<p>陣列的用法</p>
<ul>
    <li>程式請見目錄內各檔案 <a href="array/">array</a></li>
</ul>

<p>六個幸運樂透數字 (lotto6)</p>
<ul>
    <li><a href="lotto6/images.zip">下載圖檔</a></li>
    <li>-----複習------------------</li>
    <li><a href="lotto6/lucky1.php">lucky1.php</a> [<a href="show_source.php?dir=lotto6&amp;file=lucky1.php">查看原始碼</a>] 回顧：產生一個隨機幸運球</li>
    <li><a href="lotto6/lucky2.php">lucky2.php</a> [<a href="show_source.php?dir=lotto6&amp;file=lucky2.php">查看原始碼</a>] 回顧：產生多個隨機幸運球</li>
    <li><a href="lotto6/lucky3.php">lucky3.php</a> 有趣的變化</li>
    <li>-----程式的變化------------------</li>
    <li><a href="lotto6/a1.php">a1.php</a> [<a href="show_source.php?dir=lotto6&amp;file=a1.php">查看原始碼</a>] (產生六個球，有BUG，會發生重覆)</li>
    <li><a href="lotto6/a2.php">a2.php</a> [<a href="show_source.php?dir=lotto6&amp;file=a2.php">查看原始碼</a>] (六個球用陣列存放，有BUG，會發生重覆)</li>
    <li><a href="lotto6/a3.php">a3.php</a> [<a href="show_source.php?dir=lotto6&amp;file=a3.php">查看原始碼</a>] (不重覆) (含原來順序及排序後) (***主要的程式***)</li>
    <li><a href="lotto6/a4.php">a4.php</a> [<a href="show_source.php?dir=lotto6&amp;file=a4.php">查看原始碼</a>] (檢查陣列內是否有此數的程式寫法，功能同 in_array() 函式)</li>
    <li><a href="lotto6/a5.php">a5.php</a> [<a href="show_source.php?dir=lotto6&amp;file=a5.php">查看原始碼</a>] (上述的函式做成自訂函式，功能同 in_array() 函式)</li>  
    <li>-----尚有其他演算法--------------</li>
    <li><a href="lotto6/a6.php">a6.php</a> [<a href="show_source.php?dir=lotto6&amp;file=a6.php">查看原始碼</a>] 演算法：全部的球放進盒子裡，隨機挑出六個</li>
    <li><a href="lotto6/a7.php">a7.php</a> [<a href="show_source.php?dir=lotto6&amp;file=a7.php">查看原始碼</a>] 演算法：全部的球放進盒子裡，打散，挑出前面六個</li>
</ul>

<p>陣列用法補充 (array_sort) </p>
<ul>
    <li>程式請見目錄內各檔案 <a href="array_sort/">array_sort</a></li>
</ul>

<p>姓名產生器 (array) </p>
<ul>
    <li>簡易功能：<a href="array/name_generator.php">name_generator.php</a></li>
</ul>

<p>&nbsp;</p>



<h2>Class 04 (2024/03/13)</h2>
<p>客戶意見留言 (comment)</p>
<ul>
    <li>程式執行 <a href="comment/input.php">input.php</a></li>
    <li>查看原始碼：表單輸入 [<a href="show_source.php?dir=comment&amp;file=input.php">input.php</a>]</li>
    <li>查看原始碼：結果存檔 [<a href="show_source.php?dir=comment&amp;file=save.php">save.php</a>]</li>
</ul>

<p>線上問卷調查 (survey)</p>
<ul>
    <li>v1 程式執行 <a href="survey/v1/input.php">input.php</a> </li>
    <li>v2 程式執行 <a href="survey/v2/input.php">input.php</a> </li>
</ul>

<p>&nbsp;</p>



<h2>Class 03 (2024/03/11)</h2>

<p>BMI身體質量指數 (bmi)</p>
<ul>
    <li>程式執行 <a href="bmi/input.php">input.php</a> </li>
    <li>查看原始碼：表單輸入 [<a href="show_source.php?dir=bmi&amp;file=input.php">input.php</a>]</li>
    <li>查看原始碼：計算結果 [<a href="show_source.php?dir=bmi&amp;file=calc.php">calc.php</a>]</li>
</ul>
<p>利用 ChatGPT 寫的程式 (bmi)</p>
<ul>
    <li>ChatGPT 寫的程式 (並數次改良) [<a href="bmi/chatgpt_1.php">執行</a>] [<a href="show_source.php?dir=bmi&amp;file=chatgpt_1.php">原始碼chatgpt_1.php</a>]</li>
    <li>ChatGPT 寫的程式 (要求用slider) [<a href="bmi/chatgpt_2.php">執行</a>] [<a href="show_source.php?dir=bmi&amp;file=chatgpt_2.php">原始碼chatgpt_2.php</a>]</li>
    <li>ChatGPT 寫的程式 (要求文字結果) [<a href="bmi/chatgpt_3.php">執行</a>] [<a href="show_source.php?dir=bmi&amp;file=chatgpt_3.php">原始碼chatgpt_3.php</a>]</li>
</ul>
<p>BMI身體質量指數 (bmi_check)</p>
<ul>
    <li>說明：增加輸入資料檢查的 Javascript</li>
    <li>程式執行 <a href="bmi_check/input.php">input.php</a> </li>
    <li>查看原始碼：表單輸入 [<a href="show_source.php?dir=bmi_check&amp;file=input.php">input.php</a>]</li>
    <li>查看原始碼：計算結果 [<a href="show_source.php?dir=bmi_check&amp;file=calc.php">calc.php</a>]</li>
</ul>

<p>&nbsp;</p>



<h2>Class 02 (2024/03/06)</h2>

<p>九九乘法練習 (game99)</p>
<ul>
    <li>程式執行 <a href="game99/question.php">question.php</a> </li>
    <li>查看原始碼：出題 [<a href="show_source.php?dir=game99&amp;file=question.php">question.php</a>]</li>
    <li>查看原始碼：顯示答案 [<a href="show_source.php?dir=game99&amp;file=answer.php">answer.php</a>]</li>
</ul>

<p>在網頁上也會出現 GET 傳遞資料用法</p>
<ul>
    <li><a href="https://www.google.com.tw/search?q=php" target="_blank">查看更多『php』的資料</a></li>
    <li><a href="https://www.google.com.tw/search?q=程式" target="_blank">查看更多『程式』的資料</a></li>
    <a href="https://www.google.com/search?q=捍衛戰士" target="_blank">查詢更多『捍衛戰士』</a>
</ul>

<p>用表單(GET)傳遞資料用法</p>
<ul>
    <li>
        <form method="get" action="https://www.google.com/search">
        <p>查詢：<input type="text" name="q" value="PHP">
        <input type="submit" value="送出"></p>
        </form>
    </li>
    <li>上述範例請參考原始碼</li>
</ul>
<p>上週作業解答 (rand_pic)</p>
<ul>
    <li>程式執行 <a href="rand_pic/index.php">rand_pic/index.php</a></li>
</ul>

<p>&nbsp;</p>



<h2>Class 01 (2024/03/04)</h2>

<p>自我介紹 (intro)</p>
<ul>
    <li>第一個php程式 (嵌入式) <a href="intro/test.php">test.php</a> [<a href="show_source.php?dir=intro&amp;file=test.php">查看原始碼</a>]</li>
    <li>程式與網頁分離的概念 <a href="intro/me.php">me.php</a> [<a href="show_source.php?dir=intro&amp;file=me.php">查看原始碼</a>]</li>
</ul>

<p>幸運數字 (lucky)</p>
<ul>
    <li>Lucky Number <a href="lucky/index.php">index.php</a> [<a href="show_source.php?dir=lucky&amp;file=index.php">查看原始碼</a>]</li>
</ul>

<p>&nbsp;</p>



</body>
</html>