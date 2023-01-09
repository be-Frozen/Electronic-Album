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
$password=$_GET["password"];

$user=$_GET['user'];

$sql = "update user set u_password='{$password}' where u_name='{$user}';";
$result = $conn->query($sql);

$conn->close();