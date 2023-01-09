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
$password='"'.$_GET["password"].'"';

if($password=='""'){
	$sql = "select * FROM user where u_name={$name};";
}
else{
	$sql = "select * FROM user where u_name={$name} and u_password={$password};";
}
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // 输出数据
    echo "true";
} else {
    echo "false";
}
$conn->close();
return "success";