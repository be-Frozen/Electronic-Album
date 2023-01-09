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
$head='"默认/派蒙.jpg"';
if($password=='""'){
    $sql = "select * FROM user where u_name={$name};";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // 输出数据
    echo "true";
} else {
    echo "false";
}
}
else{

    $sql = "insert into user(u_name,u_password,u_head) values({$name} ,{$password},{$head});";
$result = $conn->query($sql);
mkdir("./../照片/".$_GET["name"]);
	echo "true";
}

$conn->close();
return "success";