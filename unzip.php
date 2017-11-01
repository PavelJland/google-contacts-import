<?php
$date = new DateTime();
$ts = $date->getTimestamp();
$dir = "/tmp/".$ts;

mkdir($dir, 1777);

$zip = new ZipArchive;
if ($zip->open('/tmp/export.zip') === TRUE) {
    $zip->extractTo($dir);
    $zip->close();
    $files1 = scandir($dir);
    var_dump($files1);
} else {
    echo 'ошибка';
}
?>