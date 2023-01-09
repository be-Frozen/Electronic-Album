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
$name=$_GET["name"];

$img=$_GET['img'];

$sql = "update user set u_head='{$img}' where u_name='{$name}';";
$result = $conn->query($sql);

$conn->close();