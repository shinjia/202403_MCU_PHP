<?php
// 定義檔案儲存的目標目錄
$targetDirectory = "uploads/";
if (!file_exists($targetDirectory)) {
    mkdir($targetDirectory, 0777, true);
}

$response = array();

// 檢查是否有檔案被上傳
if (isset($_FILES['fileToUpload'])) {
    // 獲取檔案相關資訊
    $file = $_FILES['fileToUpload'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];

    // 構造目標檔案路徑
    $targetFile = $targetDirectory . basename($fileName);

    // 檢查檔案是否有錯誤
    if ($fileError === 0) {
        // 檢查檔案大小
        if ($fileSize <= 5000000) { // 限制檔案大小為 5MB
            // 移動檔案到目標目錄
            if (move_uploaded_file($fileTmpName, $targetFile)) {
                $response['status'] = 'success';
                $response['message'] = '檔案上傳成功: ' . $fileName;
            } else {
                $response['status'] = 'error';
                $response['message'] = '檔案移動失敗';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = '檔案太大，上傳失敗';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = '上傳過程中發生錯誤';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = '未檢測到檔案';
}

// 回傳 JSON 格式的回應給客戶端
header('Content-Type: application/json');
echo json_encode($response);