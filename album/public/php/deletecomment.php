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

$id=$_GET["id"];
$sid=$_GET["sid"];
$commentnum=$_GET["commentnum"];
$sql = "delete FROM sharecmt where sc_id='{$id}';";
$result = $conn->query($sql);

$sql = "select s_commentnum FROM share where s_id='{$sid}';";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $commentnum=$row['s_commentnum']-1;
}

$sql = "UPDATE share SET s_commentnum='{$commentnum}' where s_id='{$sid}';";
$result = $conn->query($sql);

$conn->close();
