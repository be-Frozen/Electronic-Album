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
$conn->query("Set names 'utf8'");

$sid=$_GET["sid"];
$sql = "delete FROM share where s_id='{$sid}';";
$result = $conn->query($sql);


$conn->close();
