<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMI 計算器</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 400px;
            margin: 20px auto;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="range"] {
            width: 100%;
            margin-bottom: 10px;
            box-sizing: border-box;
        }
        input[type="number"] {
            width: 80px;
            margin-bottom: 10px;
            padding: 8px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<?php
function calculateBMI($height, $weight) {
    if ($height > 0 && $weight > 0) {
        return $weight / (($height / 100) ** 2);
    }
    return false;
}

function interpretBMI($bmi) {
    if ($bmi < 18.5) {
        return "太輕";
    } elseif ($bmi >= 18.5 && $bmi < 24.9) {
        return "標準";
    } elseif ($bmi >= 25 && $bmi < 29.9) {
        return "過重";
    } else {
        return "肥胖";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $height = isset($_POST["height"]) ? floatval($_POST["height"]) : 0;
    $weight = isset($_POST["weight"]) ? floatval($_POST["weight"]) : 0;

    $bmi = calculateBMI($height, $weight);

    if ($bmi !== false) {
        $healthStatus = interpretBMI($bmi);

        echo "<h2>結果：</h2>";
        echo "<p>身高：{$height} 公分</p>";
        echo "<p>體重：{$weight} 公斤</p>";
        echo "<p>BMI值：{$bmi}</p>";
        echo "<p>健康狀態：{$healthStatus}</p>";
    } else {
        echo "<p style='color: red;'>請輸入有效的身高和體重。</p>";
    }
}
?>

<h1>BMI 計算器</h1>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="height">身高（公分）：</label>
    <input type="range" name="height" min="0" max="300" step="1" value="0" onchange="updateTextInput(this.value, 'heightInput')">
    <input type="number" id="heightInput" name="height" min="0" max="300" step="1" value="0" oninput="updateRangeInput(this.value, 'heightRange')" required><br>

    <label for="weight">體重（公斤）：</label>
    <input type="range" name="weight" min="0" max="500" step="1" value="0" onchange="updateTextInput(this.value, 'weightInput')">
    <input type="number" id="weightInput" name="weight" min="0" max="500" step="1"
