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
$owner=$_GET["owner"];
$name=$_GET["name"];

$sql = "select a_edittime FROM album where a_name='{$name}' and a_owner='{$owner}';";

$result = $conn->query($sql);

$row = $result->fetch_assoc();
$time=$row['a_edittime'];
echo $time;

$conn->close();
