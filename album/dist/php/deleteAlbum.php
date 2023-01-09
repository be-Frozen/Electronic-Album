<?php

/**
 * 删除目录
 * @param string $path
 * @return bool
 */
function delDir(string $path): bool
{
   if (!is_dir($path)) {
       return false;
   }
   $content = scandir($path);
   foreach ($content as $v) {
       if ('.' == $v || '..' == $v) {
           continue;
       }
       $item = $path . '/' . $v;
       if (is_file($item)) {
           unlink($item);
           continue;
       }
       delDir($item);
   }
   return rmdir($path);
}



$servername = "localhost";
$username = "root";
$password = "";
$dbname = "album";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}
$owner=$_GET["owner"];
$name=$_GET["name"];

$sql = "delete from album where a_owner='{$owner}' and a_name='{$name}'";

$result = $conn->query($sql);
delDir("./../照片/".$owner."/".$name);
$conn->close();
