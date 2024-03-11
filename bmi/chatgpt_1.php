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
        input {
            width: 100%;
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $height = isset($_POST["height"]) ? floatval($_POST["height"]) : 0;
    $weight = isset($_POST["weight"]) ? floatval($_POST["weight"]) : 0;

    $bmi = calculateBMI($height, $weight);

    if ($bmi !== false) {
        echo "<h2>結果：</h2>";
        echo "<p>身高：{$height} 公分</p>";
        echo "<p>體重：{$weight} 公斤</p>";
        echo "<p>BMI值：{$bmi}</p>";
    } else {
        echo "<p style='color: red;'>請輸入有效的身高和體重。</p>";
    }
}
?>

<h1>BMI 計算器</h1>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="height">身高（公分）：</label>
    <input type="number" name="height" required><br>

    <label for="weight">體重（公斤）：</label>
    <input type="number" name="weight" required><br>

    <button type="submit">計算BMI</button>
</form>

</body>
</html>
