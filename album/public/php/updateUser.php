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

$user=$_GET["user"];
$name=$_GET["name"];
$sex=$_GET["sex"];
$birthday=$_GET["birthday"];
$signature=$_GET["signature"];

$sql = "update user set u_name='{$name}',u_sex='{$sex}',u_birthday='{$birthday}',u_signature='{$signature}' where u_name='{$user}';";

$result = $conn->query($sql);
rename("./../照片/".$user, "./../照片/".$name);

$conn->close();
