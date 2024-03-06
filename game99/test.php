<?php

// 生成九九乘法表
function generateMultiplicationTable() {
    echo "=== 九九乘法表 ===\n";
    for ($i = 1; $i <= 9; $i++) {
        for ($j = 1; $j <= 9; $j++) {
            $result = $i * $j;
            echo "$i x $j = $result\t";
        }
        echo "\n";
    }
    echo "=================\n";
}

// 主程式
generateMultiplicationTable();

?>