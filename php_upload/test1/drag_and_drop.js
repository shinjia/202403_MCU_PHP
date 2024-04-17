document.addEventListener("DOMContentLoaded", function () {
    var dropZone = document.getElementById('drop_zone');

    dropZone.addEventListener('dragover', function(e) {
        e.stopPropagation();
        e.preventDefault();
        e.dataTransfer.dropEffect = 'copy';
        // this.classList.add('hand-cursor'); // 添加手形光標類別
        this.style.cursor = 'hand';
    });

    dropZone.addEventListener('drop', function(e) {
        e.stopPropagation();
        e.preventDefault();
        var files = e.dataTransfer.files;

        for (var i = 0, f; f = files[i]; i++) {
            uploadFile(f);
        }
    });

    function uploadFile(file) {
        var url = 'upload.php'; // PHP 處理檔案上傳的 URL
        var xhr = new XMLHttpRequest();
        var formData = new FormData();
        xhr.open('POST', url, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // 檔案上傳成功後的處理
                // alert(xhr.responseText); // 或其他回應處理
                console.log(xhr.responseText);
                // 解析 JSON 字符串
                var obj = JSON.parse(xhr.responseText);
                document.getElementById('message').innerHTML = obj.message;
                // alert(obj.message);
            }
        };
        formData.append('fileToUpload', file);
        xhr.send(formData);
    }
});
