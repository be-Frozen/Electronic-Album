<?php
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
$name='"'.$_GET["name"].'"';

$img="ying.jpg";
$fp=fopen($img,'rb');
$content= addslashes(fread($fp, filesize($img)));

$sql = "update user set u_head='{$content}' where u_name={$name};";
$result = $conn->query($sql);
echo "true";
$conn->close();
return "success";