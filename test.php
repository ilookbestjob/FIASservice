<?php
session_start();
$uploadName = 'test'; // уникальное имя
if (isset($_GET['ajax'])) { // асинхронный запрос
    if (isset($_SESSION["upload_progress_$uploadName"])) { // файл загружается в данный момент
        $progress = $_SESSION["upload_progress_$uploadName"];
        $percent = round(100 * $progress['bytes_processed'] / $progress['content_length']);
        echo "Upload progress: $percent%<br /><pre>" . print_r($progress, 1) . '</pre>';
    } else {
        echo 'no uploading';
    }
    exit;
} elseif (isset($_GET['frame'])) { // покажем фрейм ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="<?=ini_get("session.upload_progress.name")?>"
                value="<?=$uploadName?>" /><br />
        <input type="file" name="file" /><br />
        <input type="submit" />
    </form>
<?php } else { ?>
    <iframe src="?frame" height="100" width="500"></iframe>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script>
        $(function() {
            setInterval(function() { // вызываем периодически
                $.get('?ajax', function(data) { // и принимаем значения
                    $('#ajax').html(data); // записывая их на страницу
                });
            }, 500);
        });
    </script>
    <div id="ajax"></div>
<?php }