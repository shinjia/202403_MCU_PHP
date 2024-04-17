<?php

// 系統代碼 (用於系統檢查，例如 session、uid,chk)
define('SYSTEM_CODE', 'WRK');

// 定義 SESSION 的變數名稱
define('DEF_SESSION_USERTYPE', 'WRK_usertype');
define('DEF_SESSION_USERCODE', 'WRK_workcode');

// 用於登入權限及密碼檢查
define('DEF_PASSWORD_FILE', 'user_password.txt');  // 密碼文字檔
define('DEF_PASSWORD_PREFIX', 'dlxikx');  // 密碼加密的前置文字

// 登入權限檢查的判斷條件，不同的系統要改名稱
define('DEF_LOGIN_ADMIN', 'WRK_ADMIN');   // 登入檢查，ADMIN
define('DEF_LOGIN_MEMBER', 'WRK_MEMBER');   // 登入檢查，MEMBER


/***** 圖檔上傳 ******************/
define('PATH_UPLOAD_ROOT', '../upload/');


/***** 表單欄位 ******************/
// 欄位1 (category)
// 定義下拉清單的各個項目
$a_category = array(
    'AIGEN' => '生成圖',
    'PAINT' => '繪畫',
    'CRAFT' => '手作',
    'LASER' => '雷切'
);

// 欄位2 (score)
// 定義下拉清單的各個項目
$a_score = array(
    5 => '出類拔萃',
    4 => '可圈可點',
    3 => '中規中矩',
    2 => '差強人意',
    1 => '乏善可陳',
    0 => '其他無評量'
);

// 欄位3 (is_open)
// 定義下拉清單的各個項目
$a_is_open = array(
    0 => '草稿',
    1 => '已發佈'
);

?>